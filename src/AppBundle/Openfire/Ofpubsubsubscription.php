<?php

namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubsubscription
 *
 * @ORM\Table(name="ofpubsubsubscription")
 * @ORM\Entity
 */
class Ofpubsubsubscription
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
     * @ORM\Column(name="owner", type="string", length=1024, nullable=false)
     */
    private $owner;

    /**
     * @var string
     *
     * @ORM\Column(name="state", type="string", length=15, nullable=false)
     */
    private $state;

    /**
     * @var integer
     *
     * @ORM\Column(name="deliver", type="integer", nullable=false)
     */
    private $deliver;

    /**
     * @var integer
     *
     * @ORM\Column(name="digest", type="integer", nullable=false)
     */
    private $digest;

    /**
     * @var integer
     *
     * @ORM\Column(name="digest_frequency", type="integer", nullable=false)
     */
    private $digestFrequency;

    /**
     * @var string
     *
     * @ORM\Column(name="expire", type="string", length=15, nullable=true)
     */
    private $expire;

    /**
     * @var integer
     *
     * @ORM\Column(name="includebody", type="integer", nullable=false)
     */
    private $includebody;

    /**
     * @var string
     *
     * @ORM\Column(name="showvalues", type="string", length=30, nullable=false)
     */
    private $showvalues;

    /**
     * @var string
     *
     * @ORM\Column(name="subscriptiontype", type="string", length=10, nullable=false)
     */
    private $subscriptiontype;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscriptiondepth", type="integer", nullable=false)
     */
    private $subscriptiondepth;

    /**
     * @var string
     *
     * @ORM\Column(name="keyword", type="string", length=200, nullable=true)
     */
    private $keyword;


}

