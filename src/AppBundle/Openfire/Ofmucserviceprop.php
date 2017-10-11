<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucserviceprop
 *
 * @ORM\Table(name="ofmucserviceprop")
 * @ORM\Entity
 */
class Ofmucserviceprop
{
    /**
     * @var integer
     *
     * @ORM\Column(name="serviceid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $serviceid;

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


}

