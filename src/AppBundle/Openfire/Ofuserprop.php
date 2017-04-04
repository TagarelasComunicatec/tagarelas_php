<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofuserprop
 *
 * @ORM\Table(name="ofuserprop")
 * @ORM\Entity
 */
class Ofuserprop
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="propvalue", type="text", nullable=false)
     */
    private $propvalue;

    public function doLoadAll($username,$name,$propvalue){
    	$this->username = $username;
    	$this->name = $name;
    	$this->propvalue = $propvalue;
    	return $this;
    }
}

