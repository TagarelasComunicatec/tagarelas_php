<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Entity\User;

use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Openfire\Ofuser;

class ProfileService {
	const EMAIL_FOUND = 1;
	const EMAIL_NOT_FOUND = 2;

	const SUCCESS_SAVE= 3;
	const FAIL_SAVE = 4;
	
	const LOGIN_CORRECT = 5;
	const LOGIN_UNCORRECT = 6;
	
	const USERS_FOUND = 7;
	const USERS_NOT_FOUND = 8;
	
	const SHORTNAME_FOUND = 1;
	const SHORTNAME_NOT_FOUND = 2;
	
	
	protected $em;
	protected $emo;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->container = $cont;
		$this->logger    = $log;
		$this->em        = $entityManager;
		$this->emo       = $this->container->get('doctrine')->getManager('openfire');
	}
	
	public function loadAllUsers(){
		$qb = $this->em->createQueryBuilder();
		$userId = $this->container->get('session')->get('userId');
		$qb->select('u.id,u.realName,u.nickname')
			->from('AppBundle:User', 'u')
		    ->where('u.id != :id')
		    ->setParameter("id", $userId);
		
		$myReturn =  $qb->getQuery()->getResult();
		
		return $myReturn;
	}
	
	public function findUserByEmail($email){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.id,u.password,u.realName,u.nickname')
			->from('AppBundle:User', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', $email );
		
		$myReturn =  $qb->getQuery()->getResult();

		return $myReturn;
	}

	public function findUserByShortName($shortName){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.id,u.password,u.realName,u.nickname')
		->from('AppBundle:User', 'u')
		->where('u.nickname LIKE :nickname')
		->setParameter('nickname', $shortName );
	
		$myReturn =  $qb->getQuery()->getResult();
	
		return $myReturn;
	}
	
	public function save(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$email   = $request->get("email");
		if (count($this->findUserByEmail($email)) >0){
			throw new \Exception('Email já está cadastrado. ' .
								 'Não foi possível cadastrar usuário. '.
					             'Entre em contato com o Suporte Tagarelas');
		}
		try{
			$user = new User();
			$ofUser = new Ofuser();
			$user->loadByRequest($request);
			$ofUser->loadByRequest($request);
			$this->em->persist($user);
			$this->em->flush();
			$this->emo->persist($ofUser);
			$this->emo->flush();
		} catch (Exception $e) {
		    throw $e;
	    }
	}

	public function loginUser(){
		$request     = $this->container->get('request_stack')->getCurrentRequest();
		$return		 = ProfileService::LOGIN_UNCORRECT;
		$users       = $this->findUserByEmail($request->get('email'));
		foreach ($users as $user){
			$return = $this->verifyUser($request, $user);
		}
		return $return;
	}

	private function verifyUser($request,$user){
		$return	= ProfileService::LOGIN_UNCORRECT;
		if( $request->get('password') === $user["password"]){
			$this->moveUserToSession($user);
			$return = ProfileService::LOGIN_CORRECT;
		}
		return $return;
	}
	
	private function moveUserToSession(Array $user){
		$this->container->get('session')->set('userId', $user['id']);
		$this->container->get('session')->set('userName', $user['realName']);
		$this->container->get('session')->set('nickName', $user['nickname']);
	}
	

}