<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofid
 *
 * @ORM\Table(name="ofid")
 * @ORM\Entity
 */
class Ofid
{
    /**
     * @var integer
     *
     * @ORM\Column(name="idtype", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofid_idtype_seq", allocationSize=1, initialValue=1)
     */
    private $idtype;

    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     */
    private $id;


}

