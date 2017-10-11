<?php
// src/AppBundle/Entity/Message.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Document\Message as BaseMessage;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_mensagem")
 * @ORM\HasLifecycleCallbacks()
 */
class Message extends BaseMessage
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @MongoDB\EmbedMany(targetDocument="AppBundle\Document\MessageMetadata")
     */
    protected $metadata;

    /**
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Document\Thread")
     */
    protected $thread;

    /**
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Entity\User")
     */
    protected $sender;
}