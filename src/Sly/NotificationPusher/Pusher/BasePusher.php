<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusherInterface;
use Sly\NotificationPusher\Collection\MessagesCollection;
use Sly\NotificationPusher\Model\MessageInterface;
use Sly\NotificationPusher\Exception\ConfigurationException;

/**
 * BasePusher.
 *
 * @uses BasePusherInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
abstract class BasePusher implements BasePusherInterface
{
    protected $config;
    protected $connection;
    protected $devicesUUIDs;
    protected $messages;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config = array())
    {
        $this->config   = array_merge($this->_getDefaultConfig(), $config);
        $this->messages = new MessagesCollection();

        if (empty($this->config['devices']) || null === $this->config['devices']) {
            throw new ConfigurationException('You must give an array of devices UUIDs to the pusher');
        }

        $this->devicesUUIDs = $this->config['devices'];
    }

    /**
     * Get default configuration.
     * 
     * @return array
     */
    protected function _getDefaultConfig()
    {
        return array(
            'dev'      => false,
            'simulate' => false,
            'feedback' => false,
        );
    }

    /**
     * {@inheritdoc}
     */
    public function addMessage(MessageInterface $message)
    {
        $this->messages->set($message);

        return $this->messages;
    }

    /**
     * {@inheritdoc}
     */
    public function getMessages()
    {
        return $this->messages->getMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function getConnection()
    {
        if (null === $this->connection) {
            $this->connection = $this->initAndGetConnection();
        }

        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function getDevicesUUIDs()
    {
        return $this->devicesUUIDs;
    }

    /**
     * {@inheritdoc}
     */
    public function push()
    {
        $this->prePush();

        $this->connection = $this->initAndGetConnection();

        foreach ($this->getMessages() as $message)
        {
            if (true === $this->config['simulate']) {
                $message->setStatus(MessageInterface::STATUS_SIMULATED_SENT);
            }
            if (true === $this->pushMessage($message)) {
                $message->setStatus(MessageInterface::STATUS_SENT);
            } else {
                $message->setStatus(MessageInterface::STATUS_FAILED);
            }
        }

        $this->postPush();

        return $this->messages->getSentMessages();
    }

    /**
     * {@inheritdoc}
     */
    public function prePush()
    { 
        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function postPush()
    {
        return $this;
    }
}
