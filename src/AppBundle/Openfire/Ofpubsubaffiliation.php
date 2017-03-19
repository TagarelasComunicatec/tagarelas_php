<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubaffiliation
 *
 * @ORM\Table(name="ofpubsubaffiliation")
 * @ORM\Entity
 */
class Ofpubsubaffiliation
{
    /**
     * @var string
     *
     * @ORM\Column(name="serviceid", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $serviceid;

    /**
     * @var string
     *
     * @ORM\Column(name="nodeid", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $nodeid;

    /**
     * @var string
     *
     * @ORM\Column(name="jid", type="string", length=1024, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jid;

    /**
     * @var string
     *
     * @ORM\Column(name="affiliation", type="string", length=10, nullable=false)
     */
    private $affiliation;


}

