<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofpresence
 *
 * @ORM\Table(name="ofpresence")
 * @ORM\Entity
 */
class Ofpresence
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofpresence_username_seq", allocationSize=1, initialValue=1)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="offlinepresence", type="text", nullable=true)
     */
    private $offlinepresence;

    /**
     * @var string
     *
     * @ORM\Column(name="offlinedate", type="string", length=15, nullable=false)
     */
    private $offlinedate;


}

