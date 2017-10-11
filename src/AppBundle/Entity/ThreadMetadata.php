<?php
// src/AppBundle/Document/ThreadMetadata.php

namespace AppBundle\Document;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Document\ThreadMetadata as BaseThreadMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_thread_metadata")
 * @ORM\HasLifecycleCallbacks()
 */
class ThreadMetadata extends BaseThreadMetadata
{
    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Document\User")
     */
    protected $participant;
}