<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Device;

/**
 * DeviceCollection.
 *
 * @uses \Sly\NotificationPusher\Collection\AbstractCollection
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class DeviceCollection extends AbstractCollection implements \IteratorAggregate
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
}
