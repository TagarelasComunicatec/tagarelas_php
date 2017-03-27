<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Openfire\Ofuser;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Utility\AppRest;
use AppBundle\Entity\GroupUser;
use AppBundle\Openfire\Ofgroupuser;

//@@TODO Preparar Login senha usa Blowfish cb
//@@TODO Rever o retorno de lista de membros users.message.user[]
//@@TODO Alterar openfire para secret Authorization -> 123456
//@@TODO Openfire-RESTAPI - https://github.com/gidkom/php-openfire-restapi


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
	}
	
	/**
	 * Do add Users to Group
	 * @param String $groupname
	 * @param Array $users
	 */
	public function addUserToGroup($groupname,$users){
		/*
		 * Check all users-group
		 */
		for ($i=0;$i < $users->size();++$i){
			$user = AppRest::doConnectRest()->getUser($users[$i]);
			$hasGroup = false;
			foreach($user->groups as $userGroup){
				if ($userGroup === $groupname){
					$hasGroup = true;
					break;
				}
			}
			/*
			 * if group not exists save groupuser
			 */
			try {
				if (! $hasGroup){
					$this->addUserGroup($user->username, $groupname);
				}
			} catch(Exception $e){
				throw $e;
			}
		}
	}
	
	private function addUserGroup($username,$groupname){
		$groupUser = new Ofgroupuser();
		$isAdministrator = ($username === $this->container->get('session')->get('username'));
		$groupUser->loadData($username, $groupname,$isAdministrator);
	}
	
	public function loadAllUsers(){
		return AppRest::doConnectRest()->getUsers();
	}
	
	public function findUserByEmail($email){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.id,u.encryptedpassword as password,u.name,u.email')
			->from('AppBundle:Ofuser', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', $email );
		
		$myReturn =  $qb->getQuery()->getResult();

		return $myReturn;
	}

	public function findUserByUsername($username){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.id,u.encryptedpassword as password,u.name,u.username')
		->from('AppBundle:Ofuser', 'u')
		->where('u.username LIKE :username')
		->setParameter('nickname', $username );
	
		$myReturn =  $qb->getQuery()->getResult();
	
		return $myReturn;
	}
	
	public function save(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$email   = $request->get("email");
		$result	 = ProfileService::FAIL_SAVE; 
		
		if (count($this->findUserByEmail($email)) >0){
			throw new \Exception('Email já está cadastrado. ' .
								 'Não foi possível cadastrar usuário. '.
					             'Entre em contato com o Suporte Tagarelas');
		}
		
		try{
			AppRest::doConnectRest()->
			addUser(
					$request->get('shortName'),
					$request->get("password"),
					$request->get('name'),
					$request->get("email")
			);
			$result	= ProfileService::SUCCESS_SAVE;
		} catch (Exception $e) {
			$result	= ProfileService::FAIL_SAVE; 
			throw $e;
	    }
	    return $result;
	    
	}

	public function loginUser(){
		$request     = $this->container->get('request_stack')->getCurrentRequest();
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
		$this->container->get('session')->set('username', $user['username']);
		$this->container->get('session')->set('name', $user['name']);
	}
	

}