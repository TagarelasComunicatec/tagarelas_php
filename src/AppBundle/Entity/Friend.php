<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_amizade")
 * @ORM\HasLifecycleCallbacks()
 */
class Friend
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="usuario_amigo", type="integer", nullable=false)
	 */
	protected $userFriend;
	
	/**
	 * @ORM\Column(name="ativo", type="boolean", nullable=true)
	 */
	protected $active;

	/**
	 * @ORM\Column(name="aceito", type="boolean", nullable=true)
	 */
	protected $accept;
	
	/**
	 * @ORM\Column(name="amigo_usuario", type="integer", nullable=false)
	 */
	protected $friendUser;


	/**
	 * @ORM\Column(name="id_relacao", type="integer", nullable=false)
	 */
	protected $relationship;
	
	
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
	 * @return 
	 */
	public function setLastUpdate($lastUpdate){
		$this->lastUpdate = $lastUpdate;
		return $this;
	}
	
	/**
	 * userFriend
	 * @return integer
	 */
	public function getUserFriend() {
		return $this->userFriend;
	}
	
	/**
	 * userFriend
	 * @param integer      	
	 */
	public function setUserFriend($userFriend) {
		$this->userFriend = $userFriend;
		return $this;
	}
	
	/**
	 * friendUser
	 * @return integer
	 */
	public function getFriendUsers() {
		return $this->friendUser;
	}
	
	/**
	 * friendUser
	 * @param integer        	
	 */
	public function setFriendUser($friendUser) {
		$this->friendUser = $friendUser;
		return $this;
	}
	
	/**
	 * relationship
	 * @return the integer
	 */
	public function getRelationship() {
		return $this->relationship;
	}
	
	/**
	 * relationship
	 * @param integer $relationship        	
	 */
	public function setRelationship($relationship) {
		$this->relationship = $relationship;
		return $this;
	}
	
	/**
	 * active
	 * @return boolean
	 */
	public function getActive() {
		return $this->active;
	}
	
	/**
	 * active
	 * @param boolean   	
	 */
	public function setActive($active) {
		$this->active = $active;
		return $this;
	}
	
	/**
	 * accept
	 * @return the unknown_type
	 */
	public function getAccept() {
		return $this->accept;
	}
	
	/**
	 * accept
	 * @param boolean       	
	 */
	public function setAccept($accept) {
		$this->accept = $accept;
		return $this;
	}
	
	


}
