<?php

namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofextcomponentconf
 *
 * @ORM\Table(name="ofextcomponentconf")
 * @ORM\Entity
 */
class Ofextcomponentconf
{
    /**
     * @var string
     *
     * @ORM\Column(name="subdomain", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofextcomponentconf_subdomain_seq", allocationSize=1, initialValue=1)
     */
    private $subdomain;

    /**
     * @var integer
     *
     * @ORM\Column(name="wildcard", type="integer", nullable=false)
     */
    private $wildcard;

    /**
     * @var string
     *
     * @ORM\Column(name="secret", type="string", length=255, nullable=true)
     */
    private $secret;

    /**
     * @var string
     *
     * @ORM\Column(name="permission", type="string", length=10, nullable=false)
     */
    private $permission;


}

