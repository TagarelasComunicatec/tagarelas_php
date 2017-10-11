<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_sessao")
 * @ORM\HasLifecycleCallbacks()
 */
class Session
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
	 * @ORM\Column(name="nome_sessao", type="string", nullable=true)
	 */
	private $sessionName;
	
	/**
	 * @var string
	 *
	 * @ORM\Column(name="dathora_sessao", type="datetime", nullable=true)
	 */
	private $dateTime;
	
	/**
	 * @ORM\Column(name="descricao", type="string", length=255, nullable=false)
	 */
	protected $description;
	
	/**
	 * @ORM\Column(name="id_usuario_criador", type="integer", nullable=true)
	 */
	protected $createdBy;
	
	/**
	 * @ORM\Column(name="visibilidade", type="boolean", length=255, nullable=false)
	 */
	protected $visibility;
	
	/**
	 * @ORM\Column(name="id_mediador", type="integer", nullable=false)
	 */
	protected $idMediator;
	
	/**
	 * @ORM\Column(name="arquivo_mensagem", type="string", length=64, nullable=false)
	 */
	protected $fileMessage;
	
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
		if (function_exists('com_create_guid') === true) {
			$this->fileMessage = trim(com_create_guid(), '{}');
		} else {
			$this->fileMessage = "checarFormatoData";
		}
			
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
	public function loadByRequest($request){
		$this->visibility = ($request->get("visibility")=== Visibility::IS_PUBLIC);
		$this->setSessionName($request->get('sessionName'))
			 ->setDateTime($request->get('datetimeSession'))
		     ->setDescription($request->get('description'));
		
		return $this;
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
	 * sessionName
	 * @return string
	 */
	public function getSessionName(){
		return $this->sessionName;
	}

	/**
	 * sessionName
	 * @param string $sessionName
	 * @return Session
	 */
	public function setSessionName($sessionName){
		$this->sessionName = $sessionName;
		return $this;
	}

	/**
	 * dateTime
	 * @return string
	 */
	public function getDateTime(){
		return $this->dateTime;
	}

	/**
	 * dateTime
	 * @param string $dateTime
	 * @return Session
	 */
	public function setDateTime($dateTime){
		$this->dateTime = \DateTime::createFromFormat("d-m-Y H:i", $dateTime);
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
	 * @return Session
	 */
	public function setDescription($description){
		$this->description = $description;
		return $this;
	}

	/**
	 * visibility
	 * @return string
	 */
	public function getVisibility(){
		return $this->visibility;
	}

	/**
	 * visibility
	 * @param string $visibility
	 * @return Session
	 */
	public function setVisibility($visibility){
		$this->visibility = $visibility;
		return $this;
	}

	/**
	 * idMediator
	 * @return string
	 */
	public function getIdMediator(){
		return $this->idMediator;
	}

	/**
	 * idMediator
	 * @param string $idMediator
	 * @return Session
	 */
	public function setIdMediator($idMediator){
		$this->idMediator = $idMediator;
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
	 * @return Session
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
	 * @return Session
	 */
	public function setLastUpdate($lastUpdate){
		$this->lastUpdate = $lastUpdate;
		return $this;
	}


	/**
	 * isDeleted
	 * @return boolean
	 */
	public function isDeleted(){
		return $this->isDeleted;
	}

	/**
	 * isDeleted
	 * @param string $isDeleted
	 * @return Session
	 */
	public function setIsDeleted($isDeleted){
		$this->isDeleted = $isDeleted;
		return $this;
	}
	
	public function getFileMessage() {
		return $this->fileMessage;
	}
	
	public function setFileMessage($fileMessage) {
		$this->fileMessage = $fileMessage;
		return $this;
	}
	
	public function getIsDeleted() {
		return $this->isDeleted;
	}
	public function getCreatedBy() {
		return $this->createdBy;
	}
	public function setCreatedBy($createdBy) {
		$this->createdBy = $createdBy;
		return $this;
	}
	
	

}
