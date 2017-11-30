<?php


namespace AppBundle\Openfire;
use Doctrine\ORM\Mapping as ORM;

/**
 * Ofmucaffiliation
 *
 * @ORM\Table(name="ofmucaffiliation")
 * @ORM\Entity
 */
 
class Ofmucaffiliation
{
    CONST  OWNER  = 10;
    CONST  ADMIN  = 20;
    CONST  MEMBER = 30;
    CONST OUTCAST = 40;
    CONST NONE    = 50;
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
     * @ORM\Column(name="jid", type="string", length=1024, nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="NONE")
     */
    private $jid;

    /**
     * @var integer
     *
     * @ORM\Column(name="affiliation", type="integer", nullable=false)
     */
    private $affiliation;

    
    public function loadData($roomid = 0,
                             $email = '',
                             $affiliation=50){
        $this->roomid = $roomid; 
        $this->jid  = $email;
        $this->affiliation = $affiliation; 
    }

}

