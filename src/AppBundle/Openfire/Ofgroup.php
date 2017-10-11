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
     * @ORM\GeneratedValue(strategy="SEQUENCE")
     * @ORM\SequenceGenerator(sequenceName="ofgroup_groupname_seq", allocationSize=1, initialValue=1)
     */
    private $groupname;

    /**
     * @var string
     *
     * @ORM\Column(name="description", type="string", length=255, nullable=true)
     */
    private $description;


}

