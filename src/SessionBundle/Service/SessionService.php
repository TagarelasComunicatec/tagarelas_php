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
    
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log) {
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	/**
	 * Load All Sessions 
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
	 * Load Sessions by status and user
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
	 * Load Groups linked to Session
	 * 
	 * @param \AppBundle\Entity\Session $Session
	 * @param string $userId
	 * @param string $status
	 * @param string $myReturn
	 * @return array selected
	 */
	private function loadSessionGroupInformation($Session, $userId, $status, $myReturn){
		
		//$results = generateQuerySessionGroup($Session, $userId, $status);
		
		//foreach ($results as $result){
			
		//}
				
		
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
	
	private function saveGroup($groups=[],$user=''){
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
	             ->info("SessionService.saveGroup members -> " . 
	                    $members);
	                      
	        $this->saveUserMembers($members,$user);
	    }
	}
	
	private function saveUserMembers($members=[],$user=''){
	  for ($i=0; $i < sizeof($members); ++$i){
	      $member = $members[$i];
	      if ($member["username"] != $user) {
	          $ofuser = $this->em
	                     ->find('Appbundle:Ofuser', $member["username"]);
	          $this->saveSingleUSer($ofuser);
	      }
	  }
	}
	
	private function saveSingleUSer($ofuser){
	    /*
	     * O cliente jã estã cadastrado na sessão
	     */
	    $jid = $ofuser->getEmail();
	    if ($this->existMemberInRoom($this->roomid,$jid)){
	        return;
	    }
	    
	    
	}
	
	private function existMemberInRoom($roomid=0, $jid=''){
	    $qb = $this->em->createQueryBuilder ();
	    $result =  $qb->select('count(m.roomid)')
                      ->from('Appbundle:Ofmember', 'm')
                      ->where('m.rooid = :roomid')
                      ->andwhere('m.jid = :jid')
	                  ->setParameter('roomid',$roomid)
	                  ->setParameter('jid', $jid) 
	                  ->getQuery()
	                  ->getSingleScalarResult();             
	    return $result > 0;                     
	}
	
	
	public function save() {
		try {

		    $request = $this->container->get('request_stack')->getCurrentRequest();
		    
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
            $this->saveGroup($groups,$user);
            $this->saveUsersMember($members,$user);
            
            $this->em->flush();
		  		    
		} catch ( \Exception $e ) {

			$this->logger->error ( "Sessao nao foi salva " . $e->__toString () );
			return Rule::FAIL_SAVE;
		} 
		return Rule::SUCCESS_SAVE;
	}
	
	private function persistSessionGroups($session, $groups, $userId) {
		
	}
	
	
	private function persistSessionMembers($session, $userId, $users) {
		
	}
}