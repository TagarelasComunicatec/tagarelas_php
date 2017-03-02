<?php
namespace SessionBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\User;
use Symfony\Component\HttpFoundation\Session\Session;

class SessionService {
	const SESSION_FOUND = 1;
	const SESSION_NOT_FOUND = 2;

	const SUCCESS_SAVE= 3;
	const FAIL_SAVE = 4;
	
	const USERS_FOUND = 7;
	const USERS_NOT_FOUND = 8;
	
	const GROUPS_FOUND = 9;
	const GROUPS_NOT_FOUND = 10;
	
	
	protected $em;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->em = $entityManager;
		$this->container = $cont;
		$this->logger = $log;
	}
	
	public function loadAllSession(){
		$qb = $this->em->createQueryBuilder();
		$userId = $this->container->get('session')->get('userId');
		$qb->select('s.id,s.sessionName,s.description')
			->from('AppBundle:Session', 's');
		
		$myReturn =  $qb->getQuery()->getResult();
		
		return $myReturn;
	}
	
	public function findSessionByName($sessionName){
		$qb = $this->em->createQueryBuilder();
		$qb->select('s.id,s.sessionName,s.description')
			->from('AppBundle:Session', 's')
			->where('s.sessionName LIKE :sessionName')
	   	    ->setParameter('sessionName', $sessionName );
		
		$myReturn =  $qb->getQuery()->getResult();

		return $myReturn;
	}
	
	
	/*public function saveUser(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$email   = $request->get("email");
		if (count($this->findUserByEmail($email)) >0){
			throw new \Exception('Email já está cadastrado. ' .
								 'Não foi possível cadastrar usuário. '.
					             'Entre em contato com o Suporte Tagarelas');
		}
		$user = new User();
		$user->loadByRequest($request);
		$this->em->persist($user);
		$this->em->flush();
	}

	public function loginUser(){
		$request     = $this->container->get('request_stack')->getCurrentRequest();
		$return		 = SessionService::LOGIN_UNCORRECT;
		$users       = $this->findUserByEmail($request->get('email'));
		foreach ($users as $user){
			$return = $this->verifyUser($request, $user);
		}
		return $return;
	}

	private function verifyUser($request,$user){
		$return	= SessionService::LOGIN_UNCORRECT;
		if( $request->get('password') === $user["password"]){
			$this->moveUserToSession($user);
			$return = SessionService::LOGIN_CORRECT;
		}
		return $return;
	}
	
	private function moveUserToSession(Array $user){
		$this->container->get('session')->set('userId', $user['id']);
		$this->container->get('session')->set('userName', $user['realName']);
		$this->container->get('session')->set('nickName', $user['nickname']);
	}
	*/

}