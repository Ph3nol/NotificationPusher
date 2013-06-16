<?php

namespace tests\units\Sly\NotificationPusher\Model;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use mageekguy\atoum;
use Sly\NotificationPusher\Model\Device as TestedModel;

/**
 * Device.
 *
 * @uses atoum\test
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Device extends atoum\test
{
    public function testConstruct()
    {
        $this->if($object = new TestedModel('t0k3n'))
            ->string($object->getToken())->isEqualTo('t0k3n')
            ->array($object->getParameters())->isEmpty()
        ;

        $this->if($object = new TestedModel('t0k3n', array('param' => 'test')))
            ->string($object->getToken())->isEqualTo('t0k3n')
            ->when($object->setToken('t0k3ns3tt3d'))
            ->string($object->getToken())->isEqualTo('t0k3ns3tt3d')
            ->array($object->getParameters())
                ->hasKey('param')
                ->contains('test')
                ->size
                    ->isEqualTo(1)
        ;
    }
}
