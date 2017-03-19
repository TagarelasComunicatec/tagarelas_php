<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofrostergroups
 *
 * @ORM\Table(name="ofrostergroups", indexes={@ORM\Index(name="ofrostergroups_rosterid_idx", columns={"rosterid"})})
 * @ORM\Entity
 */
class Ofrostergroups
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rank", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $rank;

    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=255, nullable=false)
     */
    private $groupname;

    /**
     * @var \Ofroster
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     * @ORM\OneToOne(targetEntity="Ofroster")
     * @ORM\JoinColumns({
     *   @ORM\JoinColumn(name="rosterid", referencedColumnName="rosterid")
     * })
     */
    private $rosterid;


}

