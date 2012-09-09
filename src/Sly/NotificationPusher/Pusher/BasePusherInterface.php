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
     * Get configuration.
     *
     * @return array
     */
    public function getConfig();

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
     * Get connection.
     * 
     * @return mixed
     */
    public function getConnection();

    /**
     * Get devices UUIDs.
     *
     * @return array
     */
    public function getDevicesUUIDs();

    /**
     * Push.
     */
    public function push();

    /**
     * prePush method.
     *
     * @return BasePusher
     */
    public function prePush();

    /**
     * postPush method.
     *
     * @return BasePusher
     */
    public function postPush();
}
