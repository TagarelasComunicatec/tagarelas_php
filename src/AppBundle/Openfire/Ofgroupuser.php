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
    /**
     * @var ìnt
     *
     * @ORM\Column(name="id", type="integer", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
	private $id;
	
	/**
	 * @var String
	 * @ORM\Column(name="groupname", type="string", length=50, nullable=false)
	 */
	
    private $groupname;

    /**
     * @var string
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     */
    private $username;

    /**
     * @var integer
     * @ORM\Column(name="administrator", type="integer", nullable=false)
     */
    private $isAdministrator;

	public function loadData($username,$groupname,$isAdministrator){
		$this->id        = 0;
		$this->username  = $username;
		$this->groupname = $groupname;
		$isAdministrator = $isAdministrator;
	}
}

