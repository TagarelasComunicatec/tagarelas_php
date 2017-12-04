<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucroomprop
 *
 * @ORM\Table(name="ofmucroomprop")
 * @ORM\Entity
 */
class Ofmucroomprop
{
    /**
     * @var integer
     *
     * @ORM\Column(name="roomid", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $roomid;

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
     * @ORM\Column(name="propvalue", type="text", nullable=false)
     */
    private $propvalue;

    public function loadData($roomid,$name,$propvalue){
        $this->roomid = $roomid;
        $this->name = $name;
        $this->propvalue = $propvalue;
    }
}

