<?php
// src/AppBundle/Document/MessageMetadata.php

namespace AppBundle\Document;

use Doctrine\ORM\Mapping as ORM;
use FOS\MessageBundle\Document\MessageMetadata as BaseMessageMetadata;

/**
 * @ORM\Entity
 * @ORM\Table(name="tg_mensagem_metadata")
 * @ORM\HasLifecycleCallbacks()
 */
class MessageMetadata extends BaseMessageMetadata
{
    /**
     * @ODM\ReferenceOne(targetDocument="AppBundle\Entity\User")
     */
    protected $participant;
}