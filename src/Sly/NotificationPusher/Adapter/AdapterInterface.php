<?php

namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Model\Push;

/**
 * AdapterInterface.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
interface AdapterInterface
{
    /**
     * Push.
     *
     * @return \Sly\NotificationPusher\Collection\DeviceCollection
     */
    public function push(Push $push);

    /**
     * Supports.
     * 
     * @param string $token Token
     * 
     * @return boolean
     */
    public function supports($token);

    /**
     * Get default parameters.
     * 
     * @return array
     */
    public function getDefaultParameters();

    /**
     * Get required parameters.
     * 
     * @return array
     */
    public function getRequiredParameters();
}
