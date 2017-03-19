<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofsecurityauditlog
 *
 * @ORM\Table(name="ofsecurityauditlog", indexes={@ORM\Index(name="ofsecurityauditlog_tstamp_idx", columns={"entrystamp"}), @ORM\Index(name="ofsecurityauditlog_uname_idx", columns={"username"})})
 * @ORM\Entity
 */
class Ofsecurityauditlog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="msgid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofsecurityauditlog_msgid_seq", allocationSize=1, initialValue=1)
     */
    private $msgid;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="entrystamp", type="bigint", nullable=false)
     */
    private $entrystamp;

    /**
     * @var string
     *
     * @ORM\Column(name="summary", type="string", length=255, nullable=false)
     */
    private $summary;

    /**
     * @var string
     *
     * @ORM\Column(name="node", type="string", length=255, nullable=false)
     */
    private $node;

    /**
     * @var string
     *
     * @ORM\Column(name="details", type="text", nullable=true)
     */
    private $details;


}

