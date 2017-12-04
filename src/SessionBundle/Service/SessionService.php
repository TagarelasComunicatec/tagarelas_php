<?php

namespace SessionBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Rule;
use AppBundle\Utility\AppRest;
use AppBundle\Openfire\Ofmucroom;
use AppBundle\Openfire\Ofmucaffiliation;
use AppBundle\Openfire\Ofmucmember;

//@@TODO Session = ChatRoom no Openfire.
//@@TODO Alterar método save utilizando REST API.
//@@TODO Refazer as queries utilizando Openfire.
//@@TODO Corrigir o banco de dados incluindo ID.
//@@TODO Rotina de agenda
//@@TODO Ver qual a melhor técnica de chat para resolver chatroom.
//@@TODO Muitos dos chats funcionam com BOSH

class SessionService {

	const SESSION_FOUND     = 1;
	const SESSION_NOT_FOUND = 2;
	
	protected $em;
	private $container;
	private $logger;
    private $roomid;
    private $jidsProcessados = [];
    
    /**
     * Construtor do Serviço
     * ---------------------
     * @param EntityManager $entityManager
     * @param Container $cont
     * @param Logger $log
     */
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log) {
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	/**
	 * Carrega todas as sessões
	 * ------------------------ 
	 * @param number $limit
	 */
	public function loadAllSession($limit = 0) {
		$qb = $this->em->createQueryBuilder ();
		$qb->select ( 's.id,s.sessionName,s.description' )->from ( 'AppBundle:Session', 's' )
		   ->where ('s.dateTime >= :now')
		   ->setParameter('now', new \DateTime('now'));
		
		if (0 != $limit)
			$qb->setMaxResults($limit);
		
		$myReturn = $qb->getQuery()->getResult ();
		
		return $myReturn;
	}
	
	/**
	 * Carrega as sessões por status
	 * -----------------------------
	 */
	public function loadSessionByStatus(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$limit = intval($request->get("limit"));
		$Sessions = $this->loadAllSession($limit);
		$status =  $request->get("status");
		$userId =  $this->container->get('session')->get('userId');
		$myReturn = array();
		foreach ($Sessions as $Session){
			$myReturn = $this->loadSessionGroupInformation($Session, $userId, $status, $myReturn);
		}
		return $myReturn;
	}
	
	/**
	 * @param Session      $session
	 * @param int		   $user
	 * @param int		   $status
	 */
	private function generateQuerySessionGroup($Session,$userId,$status){
		$qb = $this->em->createQueryBuilder();
		$qb->select('gu.id,gu.idUser, gu.idGroup ,gu.userStatus')
		->from('AppBundle:GroupUser', 'gu')
		->where('gu.idGroup = :idGroup')
		->andwhere('gu.idUser = :idUser')
		->andWhere('gu.userStatus = :status')
		->setParameter("idSession", $group["id"])
		->setParameter('idUser', $userId)
		->setParameter('status', $status);
		return  $qb->getQuery()->getResult();
	}

	/**
	 * @param Session      $session
	 * @param int		   $user
	 * @param int		   $status
	 */
	private function generateQuerySessionUser($Session,$userId,$status){
		$qb = $this->em->createQueryBuilder();
		$qb->select('gu.id,gu.idUser, gu.idGroup ,gu.userStatus')
		->from('AppBundle:GroupUser', 'gu')
		->where('gu.idGroup = :idGroup')
		->andwhere('gu.idUser = :idUser')
		->andWhere('gu.userStatus = :status')
		->setParameter("idGroup", $group["id"])
		->setParameter('idUser', $userId)
		->setParameter('status', $status);
		return  $qb->getQuery()->getResult();
	}
	
	/**
	 * Localiza a Sessão pelo nome
	 * @param unknown $sessionName
	 * @return array
	 */
	public function findSessionByName($sessionName) {
		$qb = $this->em->createQueryBuilder ();
		$qb->select ( 's.name' )
		   ->from ( 'AppBundle:Ofmucroom', 's' )
		   ->where ( 's.name LIKE :sessionName' )
		   ->setParameter ( 'sessionName', $sessionName );
		
		$myReturn = $qb->getQuery ()->getResult ();
		
		return $myReturn;
	}
	
	/**
	 * Retorna o proximo elemen6to de sessão
	 */
	private function getNextSession(){ 
	    $newroomid =  $this->em->createQueryBuilder()
	                            ->select('MAX(e.roomid)')
	                            ->from('AppBundle:Ofmucroom' , 'e')
	                            ->getQuery()
	                            ->getSingleScalarResult();
	    return $newroomid + 1; 
	}
	
	/**
	 * Salva o proprietário da sessão
	 * @param User $user objeto usuário
	 */
    private function saveAffiliate($user){
       $ofmucaffiliation = new Ofmucaffiliation();
       $ofmucaffiliation -> loadData($this->roomid,
                                  $user->getEmail(),
                                  Ofmucaffiliation::OWNER);
       $this->em->persist($ofmucaffiliation);
       
    }
	
    /**
     * Salva grupos para sessão
     * @param array $groups
     * @param string $user
     */
	private function saveGroup($groups,$user=''){
	    for ($i=0; $i < sizeof($groups); ++$i){
	        $group = $groups[$i];
	        $qb = $this->em->createQueryBuilder();
	        $members = $qb->select('gu.username')
	                      ->from("AppBundle:Ofgroupuser", "gu")
	                      ->where("gu.groupname = :groupname")
	                      ->setParameter("groupname",$group["groupname"])
	                      ->getQuery()
	                      ->getResult();
	         
	        $this->logger
	             ->info("SessionService.saveGroup getType members -> " .
	                 json_encode($members));

	        $this->saveUserMembers($members,$user);
	    }
	}
	
	/**
	 * Salva convidados para a sessão
	 * @param array $members
	 * @param string $user
	 */
	private function saveUserMembers($members=[],$user=''){
	  for ($i=0; $i < sizeof($members); ++$i){
	      $member = $members[$i];
	      if ($member["username"] != $user) {
	          $ofuser = $this->em
	                     ->find('AppBundle:Ofuser', $member["username"]);
	          
	          $this->logger
	                     ->info("SessionService.saveUserMembers OfUser -> " . 
	                         $ofuser->__toString());
	                     
	          $this->saveSingleUSer($ofuser);
	      }
	  }
	}
	
	/**
	 * Salva um membro na sala de discussão
	 * @param Ofuser $ofuser
	 */
	private function saveSingleUSer($ofuser){
	    /*
	     * O cliente jã estã cadastrado na sessão
	     */
	    $jid = $ofuser->getEmail();
	    if ($jid == null || 
	        $this->existMemberInRoom($this->roomid,$jid)){
	        return;
	    }
	    try {
	            $ofmucmember = new Ofmucmember();
	            $ofmucmember->loadData($this->roomid, $ofuser);
	            $this->em->persist($ofmucmember);
	            $this->jidsProcessados[] = $jid;
	    } catch (\Exception $e){
	        return;
	    }
	    return;
	}
	
	/**
	 * Verifica se existe o membro dentro da sessão.
	 * @param number $roomid
	 * @param string $jid
	 * @return boolean
	 */
	private function existMemberInRoom($roomid=0, $jid=''){

	    /*
	     * Verifica se o jid jã foi processado.
	     */
	    for ($i=0; $i < sizeof($this->jidsProcessados) ; ++ $i){
	        if ($jid == $this->jidsProcessados[$i]){
	            return true;
	        }
	    }
	    
	    $qb = $this->em->createQueryBuilder ();
	    $result =  $qb->select('count(m.roomid)')
                      ->from('AppBundle:Ofmucmember', 'm')
                      ->where('m.roomid = :roomid')
                      ->andwhere('m.jid = :jid')
	                  ->setParameter('roomid',$roomid)
	                  ->setParameter('jid', $jid) 
	                  ->getQuery()
	                  ->getSingleScalarResult(); 
	    $this->logger
	          ->info("SessionService.existMemberInRoom ? -> $result ");
	    
	    return $result > 0;                     
	}
	
	/**
	 * Salva a sessão (room)
	 * @return number
	 */
	public function save() {
		try {

		    $request = $this->container->get('request_stack')->getCurrentRequest();
		    
		    //Impede de que um jid seja inserido mais de uma vez.
		    $this->jidsProcessados = [];
		    
		    $groups  = $request->get("groups");
		    $members = $request->get("users");
		    
		    if( $this->container->get( 'security.authorization_checker' )
		        ->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
		        $user = $this->container->get('security.token_storage')->getToken()->getUser();
		        $usernameLogged = $user->getUsername();
		    }
		    
		    $this->roomid = $this->getNextSession();
		    
		    $this->logger
		    ->info("SessionService.save newroomid gerado -> " . $this->roomid);
		    
		    $this->logger
		        ->info("SessionService.save usernameLogged -> $usernameLogged");
		    $this->logger
		        ->info("SessionService.save useremail -> "  . $user->getEmail());
		        
		        
		    $ofmucroom = new Ofmucroom();
            $ofmucroom->loadFromRequest($request, $this->roomid);
            $this->em->persist($ofmucroom);
            
            $this->saveAffiliate($user);
            
            $this->logger
                 ->info("SessionService.save getType groups -> " .
                   gettype($groups));
            
            $this->logger
                 ->info("SessionService.save getType members -> " .
                     gettype($members));
                 
                 
            $this->saveGroup($groups,$user);
            $this->saveUserMembers($members,$user);
            
            $this->em->flush();
		  		    
		} catch ( \Exception $e ) {

			$this->logger->error ( "Sessao nao foi salva " . $e->__toString () );
			return Rule::FAIL_SAVE;
		} 
		return Rule::SUCCESS_SAVE;
	}
	
}