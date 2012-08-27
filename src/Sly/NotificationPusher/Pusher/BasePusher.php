<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusherInterface;
use Sly\NotificationPusher\Collection\PushesCollection;
use Sly\NotificationPusher\Model\PushInterface;

/**
 * BasePusher.
 *
 * @uses BasePusherInterface
 * @author Cédric Dugat <ph3@slynett.com>
 */
abstract class BasePusher implements BasePusherInterface
{
    protected $config;
    protected $pushes;
    protected $connection;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config = array())
    {
        $this->config = array_merge($config, $this->_getDefaultConfig());
        $this->pushes = new PushesCollection();
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
    public function addPush(PushInterface $push)
    {
        $this->pushes->set($push);

        return $this->pushes;
    }

    /**
     * {@inheritdoc}
     */
    public function getPushes()
    {
        return $this->pushes->getPushes();
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

        foreach ($this->getPushes() as $push)
        {
            /**
             * @todo
             */
        }
    }
}