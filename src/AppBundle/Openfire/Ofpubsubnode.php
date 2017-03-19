<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpubsubnode
 *
 * @ORM\Table(name="ofpubsubnode")
 * @ORM\Entity
 */
class Ofpubsubnode
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
     * @var integer
     *
     * @ORM\Column(name="leaf", type="integer", nullable=false)
     */
    private $leaf;

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
     * @ORM\Column(name="parent", type="string", length=100, nullable=true)
     */
    private $parent;

    /**
     * @var integer
     *
     * @ORM\Column(name="deliverpayloads", type="integer", nullable=false)
     */
    private $deliverpayloads;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxpayloadsize", type="integer", nullable=true)
     */
    private $maxpayloadsize;

    /**
     * @var integer
     *
     * @ORM\Column(name="persistitems", type="integer", nullable=true)
     */
    private $persistitems;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxitems", type="integer", nullable=true)
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
     * @var integer
     *
     * @ORM\Column(name="configsubscription", type="integer", nullable=false)
     */
    private $configsubscription;

    /**
     * @var string
     *
     * @ORM\Column(name="accessmodel", type="string", length=10, nullable=false)
     */
    private $accessmodel;

    /**
     * @var string
     *
     * @ORM\Column(name="payloadtype", type="string", length=100, nullable=true)
     */
    private $payloadtype;

    /**
     * @var string
     *
     * @ORM\Column(name="bodyxslt", type="string", length=100, nullable=true)
     */
    private $bodyxslt;

    /**
     * @var string
     *
     * @ORM\Column(name="dataformxslt", type="string", length=100, nullable=true)
     */
    private $dataformxslt;

    /**
     * @var string
     *
     * @ORM\Column(name="creator", type="string", length=1024, nullable=false)
     */
    private $creator;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var string
     *
     * @ORM\Column(name="language", type="string", length=255, nullable=true)
     */
    private $language;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=50, nullable=true)
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="replypolicy", type="string", length=15, nullable=true)
     */
    private $replypolicy;

    /**
     * @var string
     *
     * @ORM\Column(name="associationpolicy", type="string", length=15, nullable=true)
     */
    private $associationpolicy;

    /**
     * @var integer
     *
     * @ORM\Column(name="maxleafnodes", type="integer", nullable=true)
     */
    private $maxleafnodes;


}

