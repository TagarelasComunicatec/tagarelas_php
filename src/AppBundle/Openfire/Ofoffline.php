<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofoffline
 *
 * @ORM\Table(name="ofoffline")
 * @ORM\Entity
 */
class Ofoffline
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="messageid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $messageid;

    /**
     * @var string
     *
     * @ORM\Column(name="creationdate", type="string", length=15, nullable=false)
     */
    private $creationdate;

    /**
     * @var integer
     *
     * @ORM\Column(name="messagesize", type="integer", nullable=false)
     */
    private $messagesize;

    /**
     * @var string
     *
     * @ORM\Column(name="stanza", type="text", nullable=false)
     */
    private $stanza;


}

