<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\MessageInterface;

/**
 * MessagesCollection.
 *
 * @uses IteratorAggregate
 * @author Cédric Dugat <ph3@slynett.com>
 */
class MessagesCollection implements \IteratorAggregate
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
     * @param MessageInterface $message Message
     */
    public function set(MessageInterface $message)
    {
        $this->coll[] = $message;
    }

    /**
     * Get messages.
     *
     * @return \ArrayIterator
     */
    public function getMessages()
    {
        return $this->coll;
    }
}