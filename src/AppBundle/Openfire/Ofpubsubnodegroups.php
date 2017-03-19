<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubnodegroups
 *
 * @ORM\Table(name="ofpubsubnodegroups", indexes={@ORM\Index(name="ofpubsubnodegroups_idx", columns={"serviceid", "nodeid"})})
 * @ORM\Entity
 */
class Ofpubsubnodegroups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofpubsubnodegroups_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="serviceid", type="string", length=100, nullable=false)
     */
    private $serviceid;

    /**
     * @var string
     *
     * @ORM\Column(name="nodeid", type="string", length=100, nullable=false)
     */
    private $nodeid;

    /**
     * @var string
     *
     * @ORM\Column(name="rostergroup", type="string", length=100, nullable=false)
     */
    private $rostergroup;


}

