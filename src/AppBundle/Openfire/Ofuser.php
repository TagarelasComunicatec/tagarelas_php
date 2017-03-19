<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofuser
 *
 * @ORM\Table(name="ofuser", indexes={@ORM\Index(name="ofuser_cdate_idx", columns={"creationdate"})})
 * @ORM\Entity
 */
class Ofuser
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
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     *
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="storedkey", type="string", length=32, nullable=true)
     */
    private $storedkey;

    /**
     * @var string
     *
     * @ORM\Column(name="serverkey", type="string", length=32, nullable=true)
     */
    private $serverkey;

    /**
     * @var string
     *
     * @ORM\Column(name="salt", type="string", length=32, nullable=true)
     */
    private $salt;

    /**
     * @var integer
     *
     * @ORM\Column(name="iterations", type="integer", nullable=true)
     */
    private $iterations;

    /**
     * @var string
     *
     * @ORM\Column(name="plainpassword", type="string", length=32, nullable=true)
     */
    private $plainpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="encryptedpassword", type="string", length=255, nullable=true)
     */
    private $encryptedpassword;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="email", type="string", length=100, nullable=true)
     */
    private $email;

    /**
     * @var string
     *
     * @ORM\Column(name="creationdate", type="string", length=15, nullable=false)
     */
    private $creationdate;

    /**
     * @var string
     *
     * @ORM\Column(name="modificationdate", type="string", length=15, nullable=false)
     */
    private $modificationdate;

    /**
     * @ORM\PrePersist
     */
    public function onPrePersist()
    {
    	//using Doctrine DateTime here
    	$this->creationdate = (new \DateTime('now'))->format('Y-m-d');
    	$this->modificationdate = (new \DateTime('now'))->format('Y-m-d');
    }
    
    /**
     * @ORM\PreUpdate
     */
    public function onPreUpdate()
    {
    	//using Doctrine DateTime here
    	$this->modificationdate = (new \DateTime('now'))->format('Y-m-d');
    }
    
    
    /**
     * Carrega o objeto com as variaveis de tela padronizadas
     * @param Request $request
     */
    public function loadByRequest($request){
    	$this->username		  			= $request->get("shortName");;
    	$this->encryptedpassword		= $request->get("password");
    	$this->name	          			= $request->get('name');
    	$this->email          			= $request->get("email");
    	$this->creationdate = (new \DateTime('now'))->format('Y-m-d');
    	$this->modificationdate = (new \DateTime('now'))->format('Y-m-d');
    }
    
}

