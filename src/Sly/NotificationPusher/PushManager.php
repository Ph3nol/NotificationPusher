<?php

namespace Sly\NotificationPusher;

use Sly\NotificationPusher\Collection\PushCollection, 
    Sly\NotificationPusher\Adapter\AdapterInterface, 
    Sly\NotificationPusher\Exception\AdapterException
;

/**
 * PushManager.
 *
 * @uses \Sly\NotificationPusher\Collection\PushCollection
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushManager extends PushCollection
{
    const ENVIRONMENT_DEV  = 'dev';
    const ENVIRONMENT_PROD = 'prod';

    /**
     * @var string
     */
    private $environment;

    /**
     * Constructor.
     * 
     * @param string $environment Environment
     */
    public function __construct($environment = self::ENVIRONMENT_DEV)
    {
        parent::__construct();

        $this->environment = $environment;
    }

    /**
     * Push.
     * 
     * @return \Sly\NotificationPusher\Collection\PushCollection
     */
    public function push()
    {
        foreach ($this as $push) {
            $adapter = $push->getAdapter();
            $adapter->setEnvironment($this->environment);

            if ($adapter->push($push)) {
                $push->setPushedAt(new \DateTime());
            }
        }

        return $this;
    }

    /**
     * Get feedback.
     *
     * @param \Sly\NotificationPusher\Adapter\AdapterInterface $adapter Adapter
     * 
     * @return array
     */
    public function getFeedback(AdapterInterface $adapter)
    {
        if (false === method_exists($adapter, 'getFeedback')) {
            throw new AdapterException(
                sprintf(
                    '%s adapter has no dedicated "getFeedback" method',
                    (string) $adapter
                )
            );
        }

        return $adapter->getFeedback();
    }
}
