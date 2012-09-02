<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusher;
use Sly\NotificationPusher\Model\MessageInterface;

/**
 * AndroidPusher class.
 *
 * @uses BasePusher
 * @author Cédric Dugat <ph3@slynett.com>
 */
class AndroidPusher extends BasePusher
{
    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        parent::__construct($config);
    }

    /**
     * {@inheritdoc}
     */
    public function initAndGetConnection()
    {
        /**
         * @todo
         */
        $connection = null;

        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function pushMessage(MessageInterface $message)
    {
        /**
         * @todo
         */
    }
}
