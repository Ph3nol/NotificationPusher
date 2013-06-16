<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Device;

/**
 * DeviceCollection.
 *
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class DeviceCollection implements \IteratorAggregate
{
    /**
     * @var \ArrayIterator
     */
    private $coll;

    /**
     * Constructor.
     *
     * @param array $devices Devices
     */
    public function __construct(array $devices = array())
    {
        $this->coll = new \ArrayIterator();

        foreach ($devices as $device) {
            $this->add($device);
        }
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->coll;
    }

    /**
     * @param \Sly\NotificationPusher\Model\Device $device Device
     */
    public function add(Device $device)
    {
        $this->coll[$device->getToken()] = $device;
    }

    /**
     * Get tokens.
     * 
     * @return array
     */
    public function getTokens()
    {
        $tokens = array();

        foreach ($this as $token => $device) {
            $tokens[] = $token;
        }

        return array_unique(array_filter($tokens));
    }

    /**
     * Get.
     * 
     * @param string $key Key
     * 
     * @return \Sly\NotificationPusher\Model\Device|false
     */
    public function get($key)
    {
        return isset($this->coll[$key]) ? $this->coll[$key] : false;
    }

    /**
     * Count.
     * 
     * @return integer
     */
    public function count()
    {
        return count($this->getIterator());
    }

    /**
     * isEmpty.
     * 
     * @return boolean
     */
    public function isEmpty()
    {
        return (bool) $this->count();
    }

    /**
     * Clear categories.
     */
    public function clear()
    {
        $this->coll = new \ArrayIterator();
    }
}
