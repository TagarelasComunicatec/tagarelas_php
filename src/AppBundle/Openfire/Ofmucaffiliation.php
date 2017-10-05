<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucaffiliation
 *
 * @ORM\Table(name="ofmucaffiliation")
 * @ORM\Entity
 */
class Ofmucaffiliation
{
    /**
     * @var integer
     *
     * @ORM\Column(name="roomid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $roomid;

    /**
     * @var string
     *
     * @ORM\Column(name="jid", type="string", length=1024, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jid;

    /**
     * @var integer
     *
     * @ORM\Column(name="affiliation", type="integer", nullable=false)
     */
    private $affiliation;


}

