<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubitem
 *
 * @ORM\Table(name="ofpubsubitem")
 * @ORM\Entity
 */
class Ofpubsubitem
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
     * @ORM\Column(name="id", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="jid", type="string", length=1024, nullable=false)
     */
    private $jid;

    /**
     * @var string
     *
     * @ORM\Column(name="creationdate", type="string", length=15, nullable=false)
     */
    private $creationdate;

    /**
     * @var string
     *
     * @ORM\Column(name="payload", type="text", nullable=true)
     */
    private $payload;


}

