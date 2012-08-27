<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusherInterface;
use Sly\NotificationPusher\Collection\MessagesCollection;
use Sly\NotificationPusher\Model\MessageInterface;

/**
 * BasePusher.
 *
 * @uses BasePusherInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
abstract class BasePusher implements BasePusherInterface
{
    protected $config;
    protected $messages;
    protected $connection;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config = array())
    {
        $this->config   = array_merge($config, $this->_getDefaultConfig());
        $this->messages = new MessagesCollection();
    }

    /**
     * Get default configuration.
     * 
     * @return array
     */
    protected function _getDefaultConfig()
    {
        return array(
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
        return $this->connection;
    }

    /**
     * {@inheritdoc}
     */
    public function push()
    {
        $this->connection = $this->initAndGetConnection();

        foreach ($this->getMessages() as $message)
        {
            /**
             * @todo
             */
        }
    }
}