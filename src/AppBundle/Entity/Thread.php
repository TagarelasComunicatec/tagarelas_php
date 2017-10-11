<?php
// src/AppBundle/Document/Thread.php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Document\Thread as BaseThread;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_thread")
 * @ORM\HasLifecycleCallbacks()
 */
class Thread extends BaseThread
{
    /**
     * @MongoDB\Id
     */
    protected $id;

    /**
     * @MongoDB\ReferenceMany(targetDocument="AppBundle\Document\Message")
     */
    protected $messages;

    /**
     * @MongoDB\EmbedMany(targetDocument="AppBundle\Document\ThreadMetadata")
     */
    protected $metadata;

    /**
     * @MongoDB\ReferenceMany(targetDocument="AppBundle\Document\User")
     */
    protected $participants;

    /**
     * @MongoDB\ReferenceOne(targetDocument="AppBundle\Document\User")
     */
    protected $createdBy;
}