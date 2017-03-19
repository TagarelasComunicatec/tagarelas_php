<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofvcard
 *
 * @ORM\Table(name="ofvcard")
 * @ORM\Entity
 */
class Ofvcard
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofvcard_username_seq", allocationSize=1, initialValue=1)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="vcard", type="text", nullable=false)
     */
    private $vcard;


}

