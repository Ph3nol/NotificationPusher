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
    protected $apiKey;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (empty($this->config['applicationID']) || null === $this->config['applicationID']) {
            throw new \Exception('You must set a Google project application ID');
        }

        if (empty($this->config['apiKey']) || null === $this->config['apiKey']) {
            throw new \Exception('You must set a Google account project API key');
        }

        $this->apiKey = $this->config['apiKey'];
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
