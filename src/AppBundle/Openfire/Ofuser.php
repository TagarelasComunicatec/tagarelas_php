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
	 * @var string
	 *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
	 * @ORM\Id
	 * @ORM\GeneratedValue(strategy="NONE")
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
    
    public function __toString(){
        return $this->username . " - " . $this->email . " - " . $this->name;
    }
    
    /**
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * @return string
     */
    public function getStoredkey()
    {
        return $this->storedkey;
    }

    /**
     * @return string
     */
    public function getServerkey()
    {
        return $this->serverkey;
    }

    /**
     * @return string
     */
    public function getSalt()
    {
        return $this->salt;
    }

    /**
     * @return number
     */
    public function getIterations()
    {
        return $this->iterations;
    }

    /**
     * @return string
     */
    public function getPlainpassword()
    {
        return $this->plainpassword;
    }

    /**
     * @return string
     */
    public function getEncryptedpassword()
    {
        return $this->encryptedpassword;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getCreationdate()
    {
        return $this->creationdate;
    }

    /**
     * @return string
     */
    public function getModificationdate()
    {
        return $this->modificationdate;
    }

    /**
     * @param string $username
     */
    public function setUsername($username)
    {
        $this->username = $username;
    }

    /**
     * @param string $storedkey
     */
    public function setStoredkey($storedkey)
    {
        $this->storedkey = $storedkey;
    }

    /**
     * @param string $serverkey
     */
    public function setServerkey($serverkey)
    {
        $this->serverkey = $serverkey;
    }

    /**
     * @param string $salt
     */
    public function setSalt($salt)
    {
        $this->salt = $salt;
    }

    /**
     * @param number $iterations
     */
    public function setIterations($iterations)
    {
        $this->iterations = $iterations;
    }

    /**
     * @param string $plainpassword
     */
    public function setPlainpassword($plainpassword)
    {
        $this->plainpassword = $plainpassword;
    }

    /**
     * @param string $encryptedpassword
     */
    public function setEncryptedpassword($encryptedpassword)
    {
        $this->encryptedpassword = $encryptedpassword;
    }

    /**
     * @param string $name
     */
    public function setName($name)
    {
        $this->name = $name;
    }

    /**
     * @param string $email
     */
    public function setEmail($email)
    {
        $this->email = $email;
    }

    /**
     * @param string $creationdate
     */
    public function setCreationdate($creationdate)
    {
        $this->creationdate = $creationdate;
    }

    /**
     * @param string $modificationdate
     */
    public function setModificationdate($modificationdate)
    {
        $this->modificationdate = $modificationdate;
    }

    
    

}

