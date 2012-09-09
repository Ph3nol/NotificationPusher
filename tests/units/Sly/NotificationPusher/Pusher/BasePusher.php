<?php

namespace tests\units\Sly\NotificationPusher\Pusher;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use mageekguy\atoum;
use Sly\NotificationPusher\Pusher\BasePusher as BaseBasePusher;
use Sly\NotificationPusher\Exception\ConfigurationException;
use Sly\NotificationPusher\Model\Message;

/**
 * BasePusher.
 *
 * @uses atoum\test
 * @author Cédric Dugat <ph3@slynett.com>
 */
class BasePusher extends atoum\test
{
    public function testClass()
    {
        $this->testedClass
            ->hasNoParent()
            ->hasInterface('Sly\NotificationPusher\Pusher\BasePusherInterface')
        ;
    }

    public function testConstructWithoutDevices()
    {
        /**
         * Check no device IDs exception.
         */
        $this->assert
            ->exception(function() {
                $basePusher = new BaseBasePusher(array());
            })
                ->isInstanceOf('Sly\NotificationPusher\Exception\ConfigurationException')
        ;
    }

    public function testConstructWithDevices()
    {
        $basePusher = new BaseBasePusher(array(
            'devices' => array('ABC', 'DEF'),
        ));

        /**
         * Check device IDs.
         */
        $this->assert
            ->array($basePusher->getDevicesUUIDs())
                ->hasSize(2)
                ->containsValues(array('ABC', 'DEF'))
        ;

        /**
         * Check messages collection.
         */
        $this->assert
            ->object($basePusher->getMessages())
                ->isInstanceOf('ArrayIterator')
        ;
    }

    public function testDefaultConfig()
    {
        $basePusher = new BaseBasePusher(array(
            'devices' => array('ABC', 'DEF'),
        ));

        $basePusherConfig = $basePusher->getConfig();

        /**
         * Check some config keys and parameters.
         */
        $this->assert
            ->array($basePusherConfig)->hasKeys(array('dev', 'simulate'))
            ->boolean($basePusherConfig['dev'])->isFalse()
            ->boolean($basePusherConfig['simulate'])->isFalse()
        ;
    }

    public function testAddMessage()
    {
        $basePusher = new BaseBasePusher(array(
            'devices' => array('ABC', 'DEF'),
        ));

        /**
         * Test with 1, 2 and 3 messages.
         */
        for ($i = 1; $i < 3; $i++) {
            $message = new Message(sprintf('Test %d', $i));
            $basePusher->addMessage($message);

            $this->assert
                ->object($basePusher->getMessages())
                    ->isInstanceOf('ArrayIterator')
                    ->hasSize($i)
            ;
        }
    }
}
