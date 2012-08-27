<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Model\MessageInterface;
use Sly\NotificationPusher\Collection\PushesCollection;

/**
 * BasePusherInterface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface BasePusherInterface
{
    /**
     * Add a message.
     * 
     * @param MessageInterface $message Message
     *
     * @return MessagesCollection
     */
    public function addMessage(MessageInterface $message);

    /**
     * Get messages.
     *
     * @return \ArrayCollection
     */
    public function getMessages();

    /**
     * Get sent messages.
     * 
     * @return ArrayCollection
     */
    public function getSentMessages();

    /**
     * Get connection.
     * 
     * @return mixed
     */
    public function getConnection();

    /**
     * Push.
     */
    public function push();
}
