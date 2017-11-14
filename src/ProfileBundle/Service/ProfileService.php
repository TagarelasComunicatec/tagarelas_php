<?php
namespace ProfileBundle\Service;


use Symfony\Component\DependencyInjection\Container;
use Doctrine\ORM\EntityManager;
use Monolog\Logger;
use AppBundle\Openfire\Ofuser;
use Symfony\Component\HttpFoundation\Session\Session;
use AppBundle\Utility\AppRest;
use AppBundle\Openfire\Ofgroupuser;
use AppBundle\Openfire\Ofuserprop;
use AppBundle\Entity\Rule;
use Symfony\Component\HttpFoundation\Request;
use AppBundle\Entity\RestApi;

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
	
	public function __construct(EntityManager $entityManager, 
	                            Container $cont, 
	                            Logger $log){
		$this->container = $cont;
		$this->logger    = $log;
		$this->em        = $entityManager;
	}
	
	/**
	 * Carrega todos os ususariosd de OfUser
	 * @return array de Usuarios mo formato OfUser
	 */
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

	/**
	 * Add users to group using REST
	 * @param string $username
	 * @param string $groupname
	 */
	public function addUserToGroup($username,$groupname, $groupService = null){
		$isAdministrator = ($this->container->get('session')->get('username') == $username) ?
		                   Ofgroupuser::IS_ADMINISTRATOR :  Ofgroupuser::IS_USER;
		
	    $this->logger->info("Conteudo de username - groupname -  isAdministrator -> " .$username. '-'. $groupname.'-'.$isAdministrator);
		$groupUser = new Ofgroupuser();
	    
	    if ($username == null || $groupname == null){
	    	throw new \Exception("addUserToGroup-> empty username (".
	    						  $username .") or empty groupname (".$groupname.")");
	    }
	    
	    $groupUser->loadData($username, $groupname, $isAdministrator);
	    $this->em->flush ();
	    
	    try {
	    	$this->em->merge($groupUser);
	    	$this->em->flush ();
	    	if  ($groupService != null && ! $isAdministrator){
	    		$groupService->saveGroupUserRule($username, $groupname, Rule::USER_PENDING);
	    	}
	    	
	    } catch(\Exception $e){
	        	$this->logger->info("Informação já existe na tabela");
	    }
	}
	
	/**
	 * Locate FosUser by username ou Email
	 * @param string $username
	 * @return User class
	 */
	public function findUserByUsernameOrEmail($username=''){
	    $usermanager = $this->container->get('fos_user.user_manager');
	    $user = $usermanager->findUserByUsernameOrEmail($username);
	    return $user;
	}
	/**
	 * Save User
	 * @throws \Exception
	 * @return number Success or Fail 
	 */
	public function save(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$email   = $request->get("email");
		$result	 = ProfileService::FAIL_SAVE; 
		
		if ($this->findUserByUsernameOrEmail($email) != null){
			throw new \Exception('Email já está cadastrado. ' .
								 'Não foi possível cadastrar usuário. '.
					             'Entre em contato com o Suporte Tagarelas');
		}
		
		try{
		    $restapi = RestApi::getInstance()
		              ->setSecret($this->container->getParameter("restapi_secret"))
		              ->setHost($this->container->getParameter("restapi_host"))
		              ->setPort($this->container->getParameter("restapi_port"))
		              ->setUseSSL($this->container->getParameter("restapi_useSSL"))
		              ->setServer(($this->container->getParameter("restapi_server")))
		              ->setplugin($this->container->getParameter("restapi_plugin"));
		    
		    AppRest::doConnectRest($restapi)->
			addUser(
					$request->get('shortName'),
				    $this->container->getParameter("openfire_secret"),
					$request->get('name'),
					$request->get("email")
			);
			
			// ====================================================
			// Salva registro em FosUser para checar login e senha.
			// ====================================================
			$this->saveFosUser($request);
			
			$this->em->flush() ;
			 
			$result	= ProfileService::SUCCESS_SAVE;
		
		} catch (\Exception $e) {
			$result	= ProfileService::FAIL_SAVE; 
			$this->logger->err("Erro em salvar o usuario -> $e");
			throw $e;
	    }
	    return $result;
	    
	}
    
	/**
	 * Salva os dados de FosUser
	 * @param Request $request
	 */
	private function saveFosUser(Request $request){
	    try {
        	    $userManager = $this->container->get("fos_user.user_manager");
        	    $user = $userManager->createUser();
        	    $user->setUsername($request->get('shortName'));
        	    $user->setNickname($request->get('shortName'));
        	    $user->setUsernameCanonical($request->get('shortName'));
        	    $user->setRealname($request->get('name'));
        	    $user->setPlainPassword($request->get('password'));
        	    $user->setEmail($request->get('email'));
        	    $user->setEmailCanonical($request->get('email'));
        	    
        	    $user->setEnabled(true);
        	    $role = array(0 => "ROLE_USER");
        	    $user->setRoles($role);
        	   
        	    $userManager->updateUser($user);
	    } catch (\Exception $e){
	        $this->logger->err("Erro em salvar FOSUSERBUNDLE -> $e");
	        throw $e;
	    }
	}
    
	/**
	 * Save the new Password from User
	 * @return number - SUCESS or FAIL 
	 */
	public function saveChangedPassword(){
		try{
		    $request = $this->container->get('request_stack')->getCurrentRequest();
		    $user = $this->container->get("user");
		    $password = $request->get("password");
		    $userManager = $this->container->get("fos_user.user_manager");
		    $user->setPlainPassword($password);
			$userManager->updatePassword($user);
		} catch (\Exception $e){
			$this->logger->error("saveChangePassword - Erro em FOSUSERBUNDLE ->" . $e->__toString());
			return ProfileService::FAIL_SAVE;
		}
	}
	
	/**
	 * Delete user from database
	 * @deprecated
	 */
	public function cancelUser(){
		$request  = $this->container->get('request_stack')->getCurrentRequest();
		$username = $request->get("username");
		AppRest::doConnectRest()->deleteUser($username);
	}
	
	/**
	 * Update user data to FOSUSER  table
	 * @return number SUCCESS or FAIL
	 */
	public function updateUserData(){
		try{
		    /*
		     * load data from container (Dependence Injection)
		     */
		    $request  = $this->container->get('request_stack')->getCurrentRequest();
			$user  = $this->container->get("user");
			$userManager = $this->container->get("fos_user.user_manager");
			/*
			 * save avatar file.
			 */
			$avatar = $this->persistImage($user);
			$user->setRealname($request->get("name"));
			$user->setEmailCanonical($request->get("email"));
			$user->setAvatar($avatar);
			/*
			 * update the user data
			 */
			$userManager->updateUser();
			
			/*
			 * Uodate the Avatar
			 */
			return ProfileService::SUCCESS_SAVE;
			
		} catch(\Exception $e){
			$this->logger->error("updateUserData - Erro em FOSUSERBUNDLE ->" . $e->__toString());
			return ProfileService::FAIL_SAVE;
		}
	}

	/**
	 * Persist the image user of avatar to FOSUSERBUNDLE
	 * @return string - cript name of file.
	 */
	private function persistImage(){
		$request = $this->container->get('request_stack')->getCurrentRequest();
		$user  = $this->container->get("user");
		$file = $request->files->get("file");
		$path = $this->container->getParameter('profile_images_directory') .'/';
		if (is_null($file)) {
			return 'default.png';
		}
		$filename = md5(uniqid()).'.'.$file->getClientOriginalExtension();
		$this->logger->info("persistImage -> user: ". $user->getUsername() .
		                    " arquivo de imagem salvo:" . $filename);
		
		$file->move( $path, $filename);
		return $filename;
	}
	

}