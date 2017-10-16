<?php
// src/AppBundle/Openfire/User.php

namespace AppBundle\Openfire;

use Doctrine\ORM\Mapping as ORM;
use FOS\UserBundle\Model\User as BaseUser;
use FOS\MessageBundle\Model\ParticipantInterface;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_usuario")
 * @ORM\HasLifecycleCallbacks()
 */
class User extends BaseUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @var string
	 *
	 * @ORM\Column(name="facebook_id", type="string", nullable=true)
	 */
	private $facebookID;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="google_id", type="string", nullable=true)
	 */
	private $googleID;
	
	/**
	 * @ORM\Column(name="nick_name", type="string", length=255, nullable=false)
	 */
	protected $nickname;
	
	/**
	 * @ORM\Column(name="real_name", type="string", length=255, nullable=false)
	 */
	protected $realName;
	
	/**
	 * @ORM\Column(name="avatar", type="string", length=512, nullable=true)
	 */
	protected $avatar;
	
	/**
	 * @ORM\Column(name="data_criacao", type="datetime", nullable=true)
	 */
	protected $created;
	
	/**
	 * @ORM\Column(name="ultima_atualizacao", type="datetime", nullable=true)
	 */
	protected $lastUpdate;

	/**
	 * @ORM\Column(name="deletado", type="boolean", nullable=false)
	 */
	protected $isDeleted;
	
	/**
	 * Carrega o objeto com as variaveis de tela padronizadas
	 * @param Request $request
	 */
	public function loadByRequest($request){
		$this->id						= 0;
		$this->email          			= $request->get("email");
		$this->emailCanonical 			= $this->email;
		$this->name	          			= $request->get('name');
		$this->nickname       			= $request->get('shortName');
		$this->password		  			= $request->get("password");
		$this->username		  			= $this->name;
		$this->usernameCanonical		= $this->name;
		$this->enabled					= true;
		$this->salt						= "DEFAULT";
		$this->roles					= array("USER");
		$this->realName					= $this->name;
		$this->isDeleted				= false;
	}
	
	/**
	 * @ORM\PrePersist
	 */
	public function onPrePersist()
	{
		//using Doctrine DateTime here
		$this->created = new \DateTime('now');
		$this->lastUpdate = new \DateTime('now');
	}

	/**
	 * @ORM\PreUpdate
	 */
	public function onPreUpdate()
	{
		//using Doctrine DateTime here
		$this->lastUpdate = new \DateTime('now');
	}
	
	public function __construct()
	{
		parent::__construct();
		// your own logic
	}
	
	/**
	 * id
	 * @return int
	 */
	public function getId(){
		return $this->id;
	}

	/**
	 * id
	 * @param int $id
	 * @return User
	 */
	public function setId($id){
		$this->id = $id;
		return $this;
	}

	/**
	 * facebookID
	 * @return string
	 */
	public function getFacebookID(){
		return $this->facebookID;
	}

	/**
	 * facebookID
	 * @param string $facebookID
	 * @return User
	 */
	public function setFacebookID($facebookID){
		$this->facebookID = $facebookID;
		return $this;
	}

	/**
	 * googleID
	 * @return string
	 */
	public function getGoogleID(){
		return $this->googleID;
	}

	/**
	 * googleID
	 * @param string $googleID
	 * @return User
	 */
	public function setGoogleID($googleID){
		$this->googleID = $googleID;
		return $this;
	}

	/**
	 * nickname
	 * @return string
	 */
	public function getNickname(){
		return $this->nickname;
	}

	/**
	 * nickname
	 * @param string $nickname
	 * @return User
	 */
	public function setNickname($nickname){
		$this->nickname = $nickname;
		return $this;
	}

	/**
	 * realName
	 * @return string
	 */
	public function getRealName(){
		return $this->realName;
	}

	/**
	 * realName
	 * @param string $realName
	 * @return User
	 */
	public function setRealName($realName){
		$this->realName = $realName;
		return $this;
	}

	/**
	 * avatar
	 * @return string
	 */
	public function getAvatar(){
		return $this->avatar;
	}

	/**
	 * avatar
	 * @param string $avatar
	 * @return User
	 */
	public function setAvatar($avatar){
		$this->avatar = $avatar;
		return $this;
	}

	/**
	 * created
	 * @return string
	 */
	public function getCreated(){
		return $this->created;
	}

	/**
	 * created
	 * @param string $created
	 * @return User
	 */
	public function setCreated($created){
		$this->created = $created;
		return $this;
	}

	/**
	 * lastUpdate
	 * @return string
	 */
	public function getLastUpdate(){
		return $this->lastUpdate;
	}

	/**
	 * lastUpdate
	 * @param string $lastUpdate
	 * @return User
	 */
	public function setLastUpdate($lastUpdate){
		$this->lastUpdate = $lastUpdate;
		return $this;
	}

	/**
	 * isDeleted
	 * @return string
	 */
	public function getIsDeleted(){
		return $this->isDeleted;
	}

	/**
	 * isDeleted
	 * @param string $isDeleted
	 * @return User
	 */
	public function setIsDeleted($isDeleted){
		$this->isDeleted = $isDeleted;
		return $this;
	}


	/**
	 * userGroups
	 * @return string
	 */
	public function getUserGroups(){
		return $this->userGroups;
	}

	/**
	 * userGroups
	 * @param string $userGroups
	 * @return User
	 */
	public function setUserGroups($userGroups){
		$this->userGroups = $userGroups;
		return $this;
	}


	/**
	 * userSessions
	 * @return string
	 */
	public function getUserSessions(){
		return $this->userSessions;
	}

	/**
	 * userSessions
	 * @param string $userSessions
	 * @return User
	 */
	public function setUserSessions($userSessions){
		$this->userSessions = $userSessions;
		return $this;
	}

	/**
	 * userFriends
	 * @return string
	 */
	public function getUserFriends(){
		return $this->userFriends;
	}

	/**
	 * userFriends
	 * @param string $userFriends
	 * @return User
	 */
	public function setUserFriends($userFriends){
		$this->userFriends = $userFriends;
		return $this;
	}

	/**
	 * friendUsers
	 * @return string
	 */
	public function getFriendUsers(){
		return $this->friendUsers;
	}

	/**
	 * friendUsers
	 * @param string $friendUsers
	 * @return User
	 */
	public function setFriendUsers($friendUsers){
		$this->friendUsers = $friendUsers;
		return $this;
	}

}
