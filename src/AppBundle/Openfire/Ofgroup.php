<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofgroup
 *
 * @ORM\Table(name="ofgroup")
 * @ORM\Entity
 */
class Ofgroup
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
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


}

