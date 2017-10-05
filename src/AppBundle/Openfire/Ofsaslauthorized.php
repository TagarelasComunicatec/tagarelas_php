<?php

namespace AppBundle\Openfire;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ofsaslauthorized
 *
 * @ORM\Table(name="ofsaslauthorized")
 * @ORM\Entity
 */
class Ofsaslauthorized
{
    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=64, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(name="principal", type="string", length=4000, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $principal;


}

