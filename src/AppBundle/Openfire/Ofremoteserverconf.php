<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofremoteserverconf
 *
 * @ORM\Table(name="ofremoteserverconf")
 * @ORM\Entity
 */
class Ofremoteserverconf
{
    /**
     * @var string
     *
     * @ORM\Column(name="xmppdomain", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofremoteserverconf_xmppdomain_seq", allocationSize=1, initialValue=1)
     */
    private $xmppdomain;

    /**
     * @var integer
     *
     * @ORM\Column(name="remoteport", type="integer", nullable=true)
     */
    private $remoteport;

    /**
     * @var string
     *
     * @ORM\Column(name="permission", type="string", length=10, nullable=false)
     */
    private $permission;


}

