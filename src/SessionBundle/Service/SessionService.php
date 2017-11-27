<?php

namespace SessionBundle\Service;

use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Entity\Rule;
use AppBundle\Utility\AppRest;
use AppBundle\Openfire\Ofmucroom;

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
	public function save() {
		try {

		    $request = $this->container->get('request_stack')->getCurrentRequest();
		    
		    if( $this->container->get( 'security.authorization_checker' )
		        ->isGranted( 'IS_AUTHENTICATED_FULLY' ) ) {
		        $user = $this->container->get('security.token_storage')->getToken()->getUser();
		        $usernameLogged = $user->getUsername();
		    }
		    
		    $this->logger->info("SessionService.save usernameLogged -> $usernameLogged");
            $ofmucroom = new Ofmucroom();
            $ofmucroom->loadFromRequest($request);
            $this->em->persist($ofmucroom);
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