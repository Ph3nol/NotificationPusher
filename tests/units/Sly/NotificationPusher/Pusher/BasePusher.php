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

        $this->assert
            ->array($basePusherConfig)->hasKeys(array('dev', 'simulate'))
            ->boolean($basePusherConfig['dev'])->isFalse()
            ->boolean($basePusherConfig['simulate'])->isFalse()
        ;
    }

    public function testGetDeviceUUIDs()
    {
        $basePusher = new BaseBasePusher(array(
            'devices' => array('ABC', 'DEF', null, '', false),
        ));

        $this->assert
            ->array($basePusher->getDevicesUUIDs())
                ->hasSize(2)
                ->containsValues(array('ABC', 'DEF'))
        ;
    }

    public function testAddMessage()
    {
        $basePusher = new BaseBasePusher(array(
            'devices' => array('ABC', 'DEF'),
        ));

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
