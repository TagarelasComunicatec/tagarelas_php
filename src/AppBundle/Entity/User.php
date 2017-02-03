<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="usuario")
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
	protected $data_criacao;
	
	/**
	 * @ORM\Column(name="ultimo_login", type="datetime", nullable=true)
	 */
	protected $ultimo_login;
	
	/**
	 * @ORM\Column(name="ultima_atualizacao", type="datetime", nullable=true)
	 */
	protected $ultima_atualizacao;
	
	/**
	 * @ORM\PrePersist
	 */
	public function onPrePersist()
	{
		//using Doctrine DateTime here
		$this->data_criacao = new \DateTime('now');
		$this->ultima_atualizacao = new \DateTime('now');
	}
	/**
	 * @ORM\PreUpdate
	 */
	public function onPreUpdate()
	{
		//using Doctrine DateTime here
		$this->ultima_atualizacao = new \DateTime('now');
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
	 * data_criacao
	 * @return string
	 */
	public function getData_criacao(){
		return $this->data_criacao;
	}

	/**
	 * data_criacao
	 * @param string $data_criacao
	 * @return User
	 */
	public function setData_criacao($data_criacao){
		$this->data_criacao = $data_criacao;
		return $this;
	}

	/**
	 * ultimo_login
	 * @return string
	 */
	public function getUltimo_login(){
		return $this->ultimo_login;
	}

	/**
	 * ultimo_login
	 * @param string $ultimo_login
	 * @return User
	 */
	public function setUltimo_login($ultimo_login){
		$this->ultimo_login = $ultimo_login;
		return $this;
	}

	/**
	 * ultima_atualizacao
	 * @return string
	 */
	public function getUltima_atualizacao(){
		return $this->ultima_atualizacao;
	}

	/**
	 * ultima_atualizacao
	 * @param string $ultima_atualizacao
	 * @return User
	 */
	public function setUltima_atualizacao($ultima_atualizacao){
		$this->ultima_atualizacao = $ultima_atualizacao;
		return $this;
	}

}
