<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofgroupuser
 *
 * @ORM\Table(name="ofgroupuser")
 * @ORM\Entity
 */
class Ofgroupuser
{
    /**
     * @var string
     *
     * @ORM\Column(name="groupname", type="string", length=50, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $groupname;

    /**
     * @var string
     *
     * @ORM\Column(name="username", type="string", length=100, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $username;

    /**
     * @var integer
     *
     * @ORM\Column(name="administrator", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $administrator;


}

