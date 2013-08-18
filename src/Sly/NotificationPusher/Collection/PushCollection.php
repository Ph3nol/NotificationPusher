<?php

namespace Sly\NotificationPusher\Collection;

use Sly\NotificationPusher\Model\Push;

/**
 * PushCollection.
 *
 * @uses \Sly\NotificationPusher\Collection\AbstractCollection
 * @uses \IteratorAggregate
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushCollection extends AbstractCollection implements \IteratorAggregate
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
}
