<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofgroupprop
 *
 * @ORM\Table(name="ofgroupprop")
 * @ORM\Entity
 */
class Ofgroupprop
{
    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupname;

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

