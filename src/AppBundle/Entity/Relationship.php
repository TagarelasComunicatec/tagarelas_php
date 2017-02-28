<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tipo_amizade")
 * @ORM\HasLifecycleCallbacks()
 */
class Relationship
{
	/**
	 * @ORM\Id
	 * @ORM\Column(type="integer")
	 * @ORM\GeneratedValue(strategy="AUTO")
	 */
	protected $id;

	/**
	 * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
	 */
	protected $description;

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
	 * description
	 * @return string
	 */
	public function getDescription(){
		return $this->description;
	}

	/**
	 * description
	 * @param string $description
	 * @return Relationship
	 */
	public function setDescription($description){
		$this->description = $description;
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
	 * @return Relationship
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
	 * @return Relationship
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
	 * @return Relationship
	 */
	public function setIsDeleted($isDeleted){
		$this->isDeleted = $isDeleted;
		return $this;
	}

	/**
	 * relationships
	 * @return string
	 */
	public function getRelationships(){
		return $this->relationships;
	}

	/**
	 * relationships
	 * @param string $relationships
	 * @return Relationship
	 */
	public function setRelationships($relationships){
		$this->relationships = $relationships;
		return $this;
	}

}
