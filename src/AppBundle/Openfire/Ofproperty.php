<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofproperty
 *
 * @ORM\Table(name="ofproperty")
 * @ORM\Entity
 */
class Ofproperty
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofproperty_name_seq", allocationSize=1, initialValue=1)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="propvalue", type="string", length=4000, nullable=false)
     */
    private $propvalue;


}

