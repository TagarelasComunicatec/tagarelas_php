<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofprivacylist
 *
 * @ORM\Table(name="ofprivacylist", indexes={@ORM\Index(name="ofprivacylist_default_idx", columns={"username", "isdefault"})})
 * @ORM\Entity
 */
class Ofprivacylist
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
     * @var integer
     *
     * @ORM\Column(name="isdefault", type="integer", nullable=false)
     */
    private $isdefault;

    /**
     * @var string
     *
     * @ORM\Column(name="list", type="text", nullable=false)
     */
    private $list;


}

