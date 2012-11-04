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

    /**
     * __call method.
     *
     * @param string $method    Called method
     * @param string $arguments Called method arguments
     */
    public function __call($method, $arguments)
    {
        if (true == preg_match('/get(.*)Messages/', $method, $matches)) {
            switch ($matches[1]) {
                case 'Sent':
                    $messagesStatus = MessageInterface::STATUS_SENT;
                    break;
                case 'Failed':
                    $messagesStatus = MessageInterface::STATUS_FAILED;
                    break;
            }

            $statusedMessages = new $this;

            foreach ($this->getMessages() as $message) {
                if ($messagesStatus == $message->getStatus()) {
                    $statusedMessages->set($message);
                }
            }

            return $statusedMessages;
        }
    }
}
