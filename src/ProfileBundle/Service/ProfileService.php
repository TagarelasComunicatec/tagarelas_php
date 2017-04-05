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
use AppBundle\Openfire\Ofuserprop;

//@@TODO Preparar Login senha usa Blowfish cb
//@@TODO Alterar openfire para secret Authorization -> 123456
//@@SEE Openfire-RESTAPI - https://github.com/gidkom/php-openfire-restapi


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
	
	const AVATAR = 'AVATAR';
	
	protected $em;
	protected $emo;
	private   $container;
	private   $logger;
	
	public function __construct(EntityManager $entityManager, Container $cont, Logger $log){
		$this->container = $cont;
		$this->logger    = $log;
		$this->em        = $entityManager;
	}
	
	public function loadAllUsers(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		
		$outOfUsers = ['admin','openfire','candy'];
		
		if ($session->get('username') != null) 
			array($outOfUsers ,
					$session->get('username'));
		
			$qb = $this->em->createQueryBuilder();
			
			$users =   $qb->select('u.name,u.username')
			->from('AppBundle:Ofuser', 'u')
			->getQuery()
			->execute();
			$result = array();
			foreach($users as $user){
				if ( ! in_array($user["username"], $outOfUsers) ){
					array_push($result,$user);
				}
			}
			return $result;
	}
	
	public function findUserByEmail($email){
		$this->logger->info("Acessando usuario by email ->" . $email);
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.username,u.plainpassword as password,u.name,u.email')
			->from('AppBundle:Ofuser', 'u')
			->where('u.email LIKE :email')
	   	    ->setParameter('email', $email );
		
		$myReturn =  $qb->getQuery()->getResult();
		return $myReturn;
	}

	/**
	 * Add users to group using REST
	 * @param string $username
	 * @param string $groupname
	 */
	public function addUserToGroup($username,$groupname){
		$isAdministrator = ($this->container->get('session')->get('username') == $username) ?
		                   Ofgroupuser::IS_ADMINISTRATOR :  Ofgroupuser::IS_USER;
		
	    $this->logger->info("Conteudo de username - groupname -  isAdministrator -> " .$username. '-'. $groupname.'-'.$isAdministrator);
		$groupUser = new Ofgroupuser();
	    
	    if ($username == null || $groupname == null){
	    	throw new \Exception("addUserToGroup-> empty username (".
	    						  $username .") or empty groupname (".$groupname.")");
	    }
	    
	    $groupUser->loadData($username, $groupname, $isAdministrator);
	    
	    try {
	    	$this->em->merge($groupUser);
	    	$this->em->flush ();
	    } catch(Exception $e){
	    	$this->logger.info("Informação já existe na tabela");
	    }
	}
	
	/**
	 * Locate Ofuser by username
	 * @param unknown $username
	 * @return array
	 */
	public function findUserByUsername($username){
		$qb = $this->em->createQueryBuilder();
		$qb->select('u.name,u.username, u.email')
		->from('AppBundle:Ofuser', 'u')
		->where('u.username LIKE :username')
		->setParameter('username', $username );
	
		$myReturn =  $qb->getQuery()->getResult();
		$this->logger->info("result da consulta ->" . json_encode($myReturn));
		return $myReturn;
	}
	/**
	 * Save User
	 * @throws \Exception
	 * @throws Exception
	 * @return number Success or Fail 
	 */
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
		    /* Save in plainPassword */
			$this->savePlainPassword($request->get('shortName'), $request->get("password"));         
			$result	= ProfileService::SUCCESS_SAVE;
		
		} catch (Exception $e) {
			$result	= ProfileService::FAIL_SAVE; 
			throw $e;
	    }
	    return $result;
	    
	}

	private function savePlainPassword($username,$password){
		$this->em->createQueryBuilder()
			 	 ->update('AppBundle:Ofuser', 'u')
				 ->set('u.plainpassword',"'". $password."'")
				 ->where('u.username = ?1')
				 ->setParameter(1, $username)
				 ->getQuery()
				 ->execute();
		
		$this->em->flush() ;
	}
	
	/**
	 * Realize the login
	 * @return number LOGIN_CORRECT or LOGIN_UNCORRECT
	 */
	public function loginUser(){
		$request     = $this->container->get('request_stack')->getCurrentRequest();
		$users       = $this->findUserByEmail($request->get('email'));
		$result = ProfileService::LOGIN_UNCORRECT;
		foreach ($users as $user){
			$result = $this->verifyUser($request, $user);
		}
		return $result;
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
		$this->logger->info("Movendo usuario para a Sessão");
		$request     = $this->container->get('request_stack')->getCurrentRequest();
		$session = $request->getSession();
		$session->start();
		$session->set('username', $user['username']);
		$session->set('name', $user['name']);
		$session->set('email', $user['email']);
	}
	
	/**
	 * Save the new Password from User
	 * @return number - SUCESS or FAIL 
	 */
	public function saveChangedPassword(){
		try{
			
			$request  = $this->container->get('request_stack')->getCurrentRequest();
			$session = $request->getSession();
			$username = $request->get("username");
			$password = $request->get("password");
			$name     = $session->get("name");
			$email    = $session->get("email");
			AppRest::doConnectRest()->updateUser($username, $password,$name,$email);
			$this->savePlainPassword($username,$password);
		} catch (Exception $e){
			$this->logger->error("Conteudo de error by reference " . $e->__toString());
			return ProfileService::FAIL_SAVE;
		}
	}
	
	/**
	 * Delete user from database
	 */
	public function cancelUser(){
		$request  = $this->container->get('request_stack')->getCurrentRequest();
		$username = $request->get("username");
		AppRest::doConnectRest()->deleteUser($username);
	}
	
	/**
	 * Save user to database
	 * @return number SUCCESS or FAIL
	 */
	public function saveUser(){
		try{
			$request  = $this->container->get('request_stack')->getCurrentRequest();
			$userName = $request->get("username");
			/*
			 * update the user data
			 */
			$this->em->createQueryBuilder()
						->update('AppBundle:Ofuser', 'u')
						->set('u.name',"'". $request->get("name")."'")
						->set('u.email',"'". $request->get("email")."'")
						->where('u.username = ?1')
						->setParameter(1, $request->get('username'))
						->getQuery()
						->execute();			
			$this->em->flush() ;   
			
			/*
			 * Uodate the Avatar
			 */
			$avatar = $this->persistImage();
			$userAttribute = new Ofuserprop();
			$userAttribute->doLoadAll($userName, ProfileService::AVATAR, $avatar);
			$this->em->merge($userAttribute);
			$this->em->flush ();
			return ProfileService::SUCCESS_SAVE;
			
		} catch(Exception $e){
			$this->logger->error("Conteudo de error by reference " . $e->__toString());
			return ProfileService::FAIL_SAVE;
		}
	}
	
	private function persistImage(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$file = $request->files->get("file");
		$path = $this->container->getParameter('profile_images_directory') .'/';
		if (is_null($file)) {
			return 'default.png';
		}
		$filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();
		$this->logger->info("arquivo de imagem salvo:" . $filename);
		
		$file->move( $path, $filename);
		return $filename;
	}
	

}