<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_sessaogrupo")
 * @ORM\HasLifecycleCallbacks()
 */
class SessionGroup
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="id_grupo", type="integer", nullable=false)
	 */
	protected $idGroup;

	/**
	 * @ORM\Column(name="id_sessao", type="integer", nullable=false)
	 */protected $idSession;
	
	/**
	 * @ORM\Column(name="id_usuario_criador", type="integer", nullable=false)
	 */
	protected $createdBy;
	
	/**
	 * @ORM\Column(name="regras", type="string", length=255, nullable=false)
	 */
	
	protected $rules;
	
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
	
	public function getIdGroup() {
		return $this->idGroup;
	}
	
	public function setIdGroup($idGroup) {
		$this->idGroup = $idGroup;
		return $this;
	}
	
	public function getIdSession() {
		return $this->idSession;
	}
	
	public function setIdSession($idSession) {
		$this->idSession = $idSession;
		return $this;
	}
	
	public function getRules() {
		return $this->rules;
	}
	
	public function setRules($rules) {
		$this->rules = $rules;
		return $this;
	}
	
	public function getLastUpdate() {
		return $this->lastUpdate;
	}
	
	public function setLastUpdate($lastUpdate) {
		$this->lastUpdate = $lastUpdate;
		return $this;
	}
	
}
