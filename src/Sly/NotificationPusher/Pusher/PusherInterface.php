<?php

namespace Sly\NotificationPusher\Pusher;

interface PusherInterface
{
    /**
     * Initialize and get your device client connection.
     *
     * @return mixed
     */
    public function initAndGetConnection();
}