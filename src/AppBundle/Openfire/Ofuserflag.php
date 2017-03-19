<?php

namespace AppBundle\Openfire;

use Doctrine\ORM\Mapping as ORM;

/**
 * Ofuserflag
 *
 * @ORM\Table(name="ofuserflag", indexes={@ORM\Index(name="ofuserflag_stime_idx", columns={"starttime"}), @ORM\Index(name="ofuserflag_etime_idx", columns={"endtime"})})
 * @ORM\Entity
 */
class Ofuserflag
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
     * @ORM\Column(name="name", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(name="starttime", type="string", length=15, nullable=true)
     */
    private $starttime;

    /**
     * @var string
     *
     * @ORM\Column(name="endtime", type="string", length=15, nullable=true)
     */
    private $endtime;


}

