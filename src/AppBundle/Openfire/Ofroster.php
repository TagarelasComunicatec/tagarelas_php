<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofroster
 *
 * @ORM\Table(name="ofroster", indexes={@ORM\Index(name="ofroster_username_idx", columns={"username"}), @ORM\Index(name="ofroster_jid_idx", columns={"jid"})})
 * @ORM\Entity
 */
class Ofroster
{
    /**
     * @var integer
     *
     * @ORM\Column(name="rosterid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofroster_rosterid_seq", allocationSize=1, initialValue=1)
     */
    private $rosterid;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="jid", type="string", length=1024, nullable=false)
     */
    private $jid;

    /**
     * @var integer
     *
     * @ORM\Column(name="sub", type="integer", nullable=false)
     */
    private $sub;

    /**
     * @var integer
     *
     * @ORM\Column(name="ask", type="integer", nullable=false)
     */
    private $ask;

    /**
     * @var integer
     *
     * @ORM\Column(name="recv", type="integer", nullable=false)
     */
    private $recv;

    /**
     * @var string
     *
     * @ORM\Column(name="nick", type="string", length=255, nullable=true)
     */
    private $nick;


}

