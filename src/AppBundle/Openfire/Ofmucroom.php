<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucroom
 *
 * @ORM\Table(name="ofmucroom", indexes={@ORM\Index(name="ofmucroom_roomid_idx", columns={"roomid"}), @ORM\Index(name="ofmucroom_serviceid_idx", columns={"serviceid"})})
 * @ORM\Entity
 */
class Ofmucroom
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
     * @ORM\Column(name="name", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var integer
     *
     * @ORM\Column(name="roomid", type="integer", nullable=false)
     */
    private $roomid;

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
     * @var string
     *
     * @ORM\Column(name="naturalname", type="string", length=255, nullable=false)
     */
    private $naturalname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="lockeddate", type="string", length=15, nullable=false)
     */
    private $lockeddate;

    /**
     * @var string
     *
     * @ORM\Column(name="emptydate", type="string", length=15, nullable=true)
     */
    private $emptydate;

    /**
     * @var integer
     *
     * @ORM\Column(name="canchangesubject", type="integer", nullable=false)
     */
    private $canchangesubject;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxusers", type="integer", nullable=false)
     */
    private $maxusers;

    /**
     * @var integer
     *
     * @ORM\Column(name="publicroom", type="integer", nullable=false)
     */
    private $publicroom;

    /**
     * @var integer
     *
     * @ORM\Column(name="moderated", type="integer", nullable=false)
     */
    private $moderated;

    /**
     * @var integer
     *
     * @ORM\Column(name="membersonly", type="integer", nullable=false)
     */
    private $membersonly;

    /**
     * @var integer
     *
     * @ORM\Column(name="caninvite", type="integer", nullable=false)
     */
    private $caninvite;

    /**
     * @var string
     *
     * @ORM\Column(name="roompassword", type="string", length=50, nullable=true)
     */
    private $roompassword;

    /**
     * @var integer
     *
     * @ORM\Column(name="candiscoverjid", type="integer", nullable=false)
     */
    private $candiscoverjid;

    /**
     * @var integer
     *
     * @ORM\Column(name="logenabled", type="integer", nullable=false)
     */
    private $logenabled;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=100, nullable=true)
     */
    private $subject;

    /**
     * @var integer
     *
     * @ORM\Column(name="rolestobroadcast", type="integer", nullable=false)
     */
    private $rolestobroadcast;

    /**
     * @var integer
     *
     * @ORM\Column(name="usereservednick", type="integer", nullable=false)
     */
    private $usereservednick;

    /**
     * @var integer
     *
     * @ORM\Column(name="canchangenick", type="integer", nullable=false)
     */
    private $canchangenick;

    /**
     * @var integer
     *
     * @ORM\Column(name="canregister", type="integer", nullable=false)
     */
    private $canregister;

    /**
     * @var integer
     *
     * @ORM\Column(name="allowpm", type="integer", nullable=true)
     */
    private $allowpm;


}

