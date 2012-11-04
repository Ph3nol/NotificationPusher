<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Model\MessageInterface;

interface PusherInterface
{
    /**
     * Initialize and get your device client connection.
     *
     * @return mixed
     */
    public function initAndGetConnection();

    /**
     * Push message.
     *
     * @param MessageInterface $message Message
     *
     * @return boolean
     */
    public function pushMessage(MessageInterface $message);
}
