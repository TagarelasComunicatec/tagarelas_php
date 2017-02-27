<?php
// src/AppBundle/Entity/User.php

namespace AppBundle\Entity;

use FOS\UserBundle\Model\User as BaseUser;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="grupo")
 * @ORM\HasLifecycleCallbacks()
 */
class Group
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
	 * @ORM\Column(name="nome_grupo", type="string", nullable=false)
	 */
	private $groupName;
	
	/**
	 * @ORM\Column(name="avatar", type="string", length=255, nullable=true)
	 */
	protected $avatar;
	
	/**
	 * @ORM\Column(name="id_usuario_criador", type="integer", nullable=true)
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
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\GroupUser", mappedBy="groupUsers")
	 */
	protected $groupUsers;
	
	/**
	 * @var Collection
	 * @ORM\OneToMany(targetEntity="AppBundle\Entity\SessionGroup", mappedBy="groupSessions")
	 */
	protected $groupSessions;
	
	
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
	
	public function loadByRequest($request){
		$this->groupName = $request->get("groupName");
		$this->groupUsers = $request->get("groupMembers");
		return $this;
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
	 * GroupName
	 * @return string
	 */
	public function getGroupName(){
		return $this->groupName;
	}

	/**
	 * GroupName
	 * @param string $GroupName
	 * @return Group
	 */
	public function setGroupName($groupName){
		$this->groupName = $groupName;
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
	 * @return Group
	 */
	public function setAvatar($avatar){
		$this->avatar = $avatar;
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
	 * groupUsers
	 * @return string
	 */
	public function getGroupUsers(){
		return $this->groupUsers;
	}

	/**
	 * groupUsers
	 * @param string $groupUsers
	 * @return Group
	 */
	public function setGroupUsers($groupUsers){
		$this->groupUsers = $groupUsers;
		return $this;
	}


	/**
	 * groupSessions
	 * @return string
	 */
	public function getGroupSessions(){
		return $this->groupSessions;
	}

	/**
	 * groupSessions
	 * @param string $groupSessions
	 * @return Group
	 */
	public function setGroupSessions($groupSessions){
		$this->groupSessions = $groupSessions;
		return $this;
	}

}
