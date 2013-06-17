<?php

namespace tests\units\Sly\NotificationPusher\Model;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use mageekguy\atoum;
use Sly\NotificationPusher\Model\Push as TestedModel;

use Sly\NotificationPusher\Model\Message as BaseMessage;
use Sly\NotificationPusher\Model\Device as BaseDevice;
use Sly\NotificationPusher\Collection\DeviceCollection as BaseDeviceCollection;
use Sly\NotificationPusher\Adapter\Apns as BaseApnsAdapter;

/**
 * Push.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends atoum\test
{
    const APNS_TOKEN_EXAMPLE = '1111111111111111111111111111111111111111111111111111111111111111';
    const GCM_TOKEN_EXAMPLE  = '111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111111';

    public function testContructWithOneDevice()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDevice('Token1'))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message))

            ->object($object->getDevices())
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
            ->integer($object->getDevices()->count())
                ->isEqualTo(1)
            ->array($object->getOptions())
                ->isEmpty()
        ;
    }

    public function testContructWithManyDevicesAndOptions()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDeviceCollection(array(new BaseDevice('Token1'), new BaseDevice('Token2'), new BaseDevice('Token3'))))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message, array('param' => 'test')))

            ->object($object->getDevices())
                ->isInstanceOf('\Sly\NotificationPusher\Collection\DeviceCollection')
            ->integer($object->getDevices()->count())
                ->isEqualTo(3)
            ->array($object->getOptions())
                ->hasKey('param')
                ->contains('test')
                ->size
                    ->isEqualTo(1)
        ;
    }

    public function testStatus()
    {
        $this->if($this->mockClass('\Sly\NotificationPusher\Adapter\AdapterInterface', '\Mock'))
            ->and($adapter = new \Mock\AdapterInterface())
            ->and($devices = new BaseDeviceCollection(array(new BaseDevice('Token1'), new BaseDevice('Token2'), new BaseDevice('Token3'))))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($adapter, $devices, $message))

            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_PENDING)
            ->boolean($object->isSent())
                ->isFalse()

            ->when($object->sent())
            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_SENT)
            ->boolean($object->isSent())
                ->isTrue()

            ->when($object->setStatus(TestedModel::STATUS_PENDING))
            ->string($object->getStatus())
                ->isEqualTo(TestedModel::STATUS_PENDING)
            ->boolean($object->isSent())
                ->isFalse()
        ;
    }

    public function testDevicesTokensCheck()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))

            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($badDevice = new BaseDevice('BadToken'))
            ->and($message = new BaseMessage('Test'))

            ->exception(function () use ($apnsAdapter, $badDevice, $message) {
                $object = new TestedModel($apnsAdapter, $badDevice, $message);
            })
                ->isInstanceOf('\Sly\NotificationPusher\Exception\AdapterException')

            ->when($goodDevice = new BaseDevice(self::APNS_TOKEN_EXAMPLE))
            ->object($object = new TestedModel($apnsAdapter, $goodDevice, $message))
        ;
    }

    public function testAdapter()
    {
        $this->if($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Apns', '\Mock'))
            ->and($this->mockGenerator()->orphanize('__construct'))
            ->and($this->mockClass('\Sly\NotificationPusher\Adapter\Gcm', '\Mock'))

            ->and($apnsAdapter = new \mock\Apns())
            ->and($gcmAdapter = new \mock\Gcm())
            ->and($devices = new BaseDevice(self::APNS_TOKEN_EXAMPLE))
            ->and($message = new BaseMessage('Test'))

            ->and($object = new TestedModel($apnsAdapter, $devices, $message))

            ->object($object->getAdapter())
                ->isInstanceOf('\Sly\NotificationPusher\Adapter\Apns')

            ->when($object->setAdapter($gcmAdapter))
            ->and($object->setDevices(new BaseDeviceCollection(array(new BaseDevice(self::GCM_TOKEN_EXAMPLE)))))
            ->object($object->getAdapter())
                ->isInstanceOf('\Sly\NotificationPusher\Adapter\Gcm')
        ;
    }
}
