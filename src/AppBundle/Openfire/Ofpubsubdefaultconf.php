<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubdefaultconf
 *
 * @ORM\Table(name="ofpubsubdefaultconf")
 * @ORM\Entity
 */
class Ofpubsubdefaultconf
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
     * @var integer
     *
     * @ORM\Column(name="leaf", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $leaf;

    /**
     * @var integer
     *
     * @ORM\Column(name="deliverpayloads", type="integer", nullable=false)
     */
    private $deliverpayloads;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxpayloadsize", type="integer", nullable=false)
     */
    private $maxpayloadsize;

    /**
     * @var integer
     *
     * @ORM\Column(name="persistitems", type="integer", nullable=false)
     */
    private $persistitems;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxitems", type="integer", nullable=false)
     */
    private $maxitems;

    /**
     * @var integer
     *
     * @ORM\Column(name="notifyconfigchanges", type="integer", nullable=false)
     */
    private $notifyconfigchanges;

    /**
     * @var integer
     *
     * @ORM\Column(name="notifydelete", type="integer", nullable=false)
     */
    private $notifydelete;

    /**
     * @var integer
     *
     * @ORM\Column(name="notifyretract", type="integer", nullable=false)
     */
    private $notifyretract;

    /**
     * @var integer
     *
     * @ORM\Column(name="presencebased", type="integer", nullable=false)
     */
    private $presencebased;

    /**
     * @var integer
     *
     * @ORM\Column(name="senditemsubscribe", type="integer", nullable=false)
     */
    private $senditemsubscribe;

    /**
     * @var string
     *
     * @ORM\Column(name="publishermodel", type="string", length=15, nullable=false)
     */
    private $publishermodel;

    /**
     * @var integer
     *
     * @ORM\Column(name="subscriptionenabled", type="integer", nullable=false)
     */
    private $subscriptionenabled;

    /**
     * @var string
     *
     * @ORM\Column(name="accessmodel", type="string", length=10, nullable=false)
     */
    private $accessmodel;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="replypolicy", type="string", length=15, nullable=true)
     */
    private $replypolicy;

    /**
     * @var string
     *
     * @ORM\Column(name="associationpolicy", type="string", length=15, nullable=false)
     */
    private $associationpolicy;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxleafnodes", type="integer", nullable=false)
     */
    private $maxleafnodes;


}

