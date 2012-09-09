<?php

namespace tests\units\Sly\NotificationPusher\Model;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use mageekguy\atoum;
use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\MessageInterface as BaseMessageInterface;

/**
 * Message.
 *
 * @uses atoum\test
 * @author Cédric Dugat <ph3@slynett.com>
 */
class Message extends atoum\test
{
    public function testClass()
    {
        $this->testedClass
            ->hasNoParent()
            ->hasInterface('Sly\NotificationPusher\Model\MessageInterface')
        ;
    }

    public function testConstructWithoutMessage()
    {
        $message = new BaseMessage();

        $this->assert
            ->variable($message->getMessage())->isNull()
        ;
    }

    public function testConstruct()
    {
        $message = new BaseMessage('Test');

        /**
         * Test all message data after instanciation.
         */
        $this->assert
            ->string($message->getMessage())->isEqualTo('Test')
            ->string((string) $message)->isEqualTo('Test')
            ->string($message->getStatus())->isEqualTo(BaseMessageInterface::STATUS_INIT)
            ->boolean($message->hasAlert())->isTrue()
            ->integer($message->getBadge())->isEqualTo(0)
            ->string($message->getSound())->isEqualTo('default')
            ->object($message->getCreatedAt())
                ->isNotNull()
                ->isInstanceOf('\DateTime')
            ->variable($message->getSentAt())->isNull()
        ;
    }
}
