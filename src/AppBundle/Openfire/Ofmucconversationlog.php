<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucconversationlog
 *
 * @ORM\Table(name="ofmucconversationlog", indexes={@ORM\Index(name="ofmucconversationlog_time_idx", columns={"logtime"}), @ORM\Index(name="ofmucconversationlog_msg_id", columns={"messageid"})})
 * @ORM\Entity
 */
class Ofmucconversationlog
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="bigint", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofmucconversationlog_id_seq", allocationSize=1, initialValue=1)
     */
    private $id;

    /**
     * @var integer
     *
     * @ORM\Column(name="roomid", type="integer", nullable=false)
     */
    private $roomid;

    /**
     * @var integer
     *
     * @ORM\Column(name="messageid", type="integer", nullable=false)
     */
    private $messageid;

    /**
     * @var string
     *
     * @ORM\Column(name="sender", type="string", length=1024, nullable=false)
     */
    private $sender;

    /**
     * @var string
     *
     * @ORM\Column(name="nickname", type="string", length=255, nullable=true)
     */
    private $nickname;

    /**
     * @var string
     *
     * @ORM\Column(name="logtime", type="string", length=15, nullable=false)
     */
    private $logtime;

    /**
     * @var string
     *
     * @ORM\Column(name="subject", type="string", length=255, nullable=true)
     */
    private $subject;

    /**
     * @var string
     *
     * @ORM\Column(name="body", type="text", nullable=true)
     */
    private $body;

    /**
     * @var string
     *
     * @ORM\Column(name="stanza", type="text", nullable=true)
     */
    private $stanza;


}

