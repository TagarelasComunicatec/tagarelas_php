<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="sessao_usuario")
 * @ORM\HasLifecycleCallbacks()
 */
class SessionUser
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\Session", inversedBy="sessionUsers")
	 * @ORM\JoinColumn(name="id_sessao", referencedColumnName="id")
	 * @var AppBundle\Entity\Session
	 **/
	protected $sessionUsers;
	

	/**
	 *
	 * @ORM\ManyToOne(targetEntity="AppBundle\Entity\User", inversedBy="userSessions")
	 * @ORM\JoinColumn(name="id_usuario", referencedColumnName="id")
	 * @var AppBundle\Entity\User
	 **/
	protected $userSessions;
	
	/**
	 * @ORM\Column(name="id_usuario_criador", type="integer", nullable=false)
	 */
	protected $createdBy;
	
	/**
	 * @ORM\Column(name="data_criacao", type="datetime", nullable=true)
	 */
	protected $created;
	
	
	/**
	 * @ORM\Column(name="ultima_atualizacao", type="datetime", nullable=true)
	 */
	protected $lastUpdate;
	
	
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
	 * createdBy
	 * @return string
	 */
	public function getCreatedBy(){
		return $this->createdBy;
	}

	/**
	 * createdBy
	 * @param string $createdBy
	 * @return Group
	 */
	public function setCreatedBy($createdBy){
		$this->createdBy = $createdBy;
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
	 * @return Group
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
	 * @return Group
	 */
	public function setLastUpdate($lastUpdate){
		$this->lastUpdate = $lastUpdate;
		return $this;
	}





	/**
	 * sessionUsers
	 * @return string
	 */
	public function getSessionUsers(){
		return $this->sessionUsers;
	}

	/**
	 * sessionUsers
	 * @param string $sessionUsers
	 * @return GroupUser
	 */
	public function setSessionUsers($sessionUsers){
		$this->sessionUsers = $sessionUsers;
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
	 * @return GroupUser
	 */
	public function setUserSessions($userSessions){
		$this->userSessions = $userSessions;
		return $this;
	}

}
