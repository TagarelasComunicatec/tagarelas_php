<?php
use Doctrine\ORM\Mapping as ORM;

use FOS\MessageBundle\Entity\Message as BaseMessage;
use FOS\MessageBundle\Model\ThreadInterface;
use FOS\MessageBundle\Model\ParticipantInterface;
use FOS\MessageBundle\Model\MessageMetadata as ModelMessageMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_mensages")
 */

class TgMessage extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\generatedValue(strategy="AUTO")
     */
    protected $id;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Openfire\TgThread", inversedBy="messages")
     * @ORM\JoinColumn(name="thread_id", referencedColumnName="id")
     */
    protected $thread;
    
    /**
     * @ORM\ManyToOne(targetEntity="AppBundle\Openfire\TgUser")
     * @ORM\JoinColumn(name="user_id", referencedColumnName="id")
     */
    protected $sender;
  
}