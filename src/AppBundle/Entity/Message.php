<?php
// src/AppBundle/Entity/Message.php

namespace AppBundle\Entity;

use Doctrine\ODM\MongoDB\Mapping\Annotations as MongoDB;
use FOS\MessageBundle\Document\Message as BaseMessage;

/**
 * @MongoDB\Document
 */
class Message extends BaseMessage
{
    /**
     * @MongoDB\Id
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
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Document\User")
     */
    protected $sender;
}