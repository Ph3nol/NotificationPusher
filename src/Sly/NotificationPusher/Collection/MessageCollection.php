<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Message;

/**
 * MessageCollection.
 *
 * @uses \Sly\NotificationPusher\Collection\AbstractCollection
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class MessageCollection extends AbstractCollection implements \IteratorAggregate
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
}
