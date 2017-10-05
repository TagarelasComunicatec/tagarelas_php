<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofgroupuser
 *
 * @ORM\Table(name="ofgroupuser")
 * @ORM\Entity
 */
class Ofgroupuser
{
	const IS_ADMINISTRATOR = 1;
	const IS_USER = 0;
	
	/**
	 * @var String
 	 * @ORM\Column(name="groupname", type="string", length=50, nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
	 */
    private $groupname;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var integer
	 * @ORM\Column(name="administrator", type="integer", nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
     */
    private $isAdministrator;
  
    /**
     * Load dats to class
     * @param unknown $username
     * @param unknown $groupname
     * @param unknown $isAdministrator
     */
	public function loadData($username,$groupname,$isAdministrator= Ofgroupuser::IS_USER){
		$this->username  = $username;
		$this->groupname = $groupname;
		$this->isAdministrator = $isAdministrator;
	}
}

