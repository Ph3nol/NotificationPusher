<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Message;

/**
 * MessageCollection.
 *
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class MessageCollection implements \IteratorAggregate
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
     * @param \Sly\NotificationPusher\Model\Message $message Message
     */
    public function add(Message $message)
    {
        $this->coll[] = $message;
    }

    /**
     * Get.
     * 
     * @param string $key Key
     * 
     * @return \Sly\NotificationPusher\Model\Message|false
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
