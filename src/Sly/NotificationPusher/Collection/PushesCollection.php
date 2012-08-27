<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\PushInterface;

/**
 * PushesCollection.
 *
 * @uses IteratorAggregate
 * @author Cédric Dugat <ph3@slynett.com>
 */
class PushesCollection implements \IteratorAggregate
{
    protected $coll;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->coll = new \ArrayIterator();
    }

    /**
     * @return array
     */
    public function getIterator()
    {
        return $this->coll;
    }

    /**
     * Set method.
     *
     * @param string        $name Push Name
     * @param PushInterface $push Push
     */
    public function set(PushInterface $push)
    {
        $this->coll[] = $push;
    }

    /**
     * Get pushes.
     *
     * @return \ArrayIterator
     */
    public function getPushes()
    {
        return $this->coll;
    }
}