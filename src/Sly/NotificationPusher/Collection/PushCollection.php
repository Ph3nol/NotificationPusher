<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Push;

/**
 * PushCollection.
 *
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushCollection implements \IteratorAggregate
{
    /**
     * @var \ArrayIterator
     */
    private $coll;

    /**
     * Constructor.
     */
    public function __construct()
    {
        $this->coll = new \ArrayIterator();
    }

    /**
     * @return \ArrayIterator
     */
    public function getIterator()
    {
        return $this->coll;
    }

    /**
     * @param \Sly\NotificationPusher\Model\Push $push Push
     */
    public function add(Push $push)
    {
        $this->coll[] = $push;
    }

    /**
     * Get.
     * 
     * @param string $key Key
     * 
     * @return \Sly\NotificationPusher\Model\Push|false
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
