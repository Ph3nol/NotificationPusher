<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Model\BasePushInterface;
use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\PushInterface;
use Sly\NotificationPusher\Collection\PushesCollection;

/**
 * BasePusherInterface.
 *
 * @author Cédric Dugat <ph3@slynett.com>
 */
interface BasePusherInterface
{
    /**
     * Add a push.
     * 
     * @param PushInterface $push Push
     *
     * @return PushesCollection
     */
    public function addPush(PushInterface $push);

    /**
     * Get pushes.
     *
     * @return \ArrayCollection
     */
    public function getPushes();

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
