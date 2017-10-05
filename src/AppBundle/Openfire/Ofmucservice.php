<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucservice
 *
 * @ORM\Table(name="ofmucservice", indexes={@ORM\Index(name="ofmucservice_serviceid_idx", columns={"serviceid"})})
 * @ORM\Entity
 */
class Ofmucservice
{
    /**
     * @var string
     *
     * @ORM\Column(name="subdomain", type="string", length=255, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofmucservice_subdomain_seq", allocationSize=1, initialValue=1)
     */
    private $subdomain;

    /**
     * @var integer
     *
     * @ORM\Column(name="serviceid", type="integer", nullable=false)
     */
    private $serviceid;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;

    /**
     * @var integer
     *
     * @ORM\Column(name="ishidden", type="integer", nullable=false)
     */
    private $ishidden;


}

