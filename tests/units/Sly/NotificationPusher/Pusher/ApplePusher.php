<?php

namespace tests\units\Sly\NotificationPusher\Pusher;

require_once __DIR__ . '/../../../../../vendor/autoload.php';

use mageekguy\atoum;
use Sly\NotificationPusher\Pusher\ApplePusher as BaseApplePusher;

/**
 * ApplePusher.
 *
 * @uses atoum\test
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ApplePusher extends atoum\test
{
    public function testContructWithoutCertificate()
    {
        $this->assert
            ->exception(function() {
                $applePusher = new BaseApplePusher(array());
            })
                ->isInstanceOf('Sly\NotificationPusher\Exception\ConfigurationException')
        ;
    }

    public function testConstructWithFakeCertificate()
    {
        $this->assert
            ->exception(function() {
                $applePusher = new BaseApplePusher(array(
                    'certificate' => '/path/to/cert.pem',
                    'devices'     => array('ABC', 'DEF'),
                ));
            })
                ->isInstanceOf('Sly\NotificationPusher\Exception\ConfigurationException')
        ;
    }

    public function testInvalidCertificatePassphrase()
    {
        $this->assert
            ->exception(function() {
                $applePusher = new BaseApplePusher(array(
                    'certificate' => __DIR__ . '/../../../fixtures/cert_with_passphrase.pem',
                    'certificate_passphrase' => 'invalidpassphrase',
                    'devices'     => array('ABC', 'DEF'),
                ));

                $con = $applePusher->initAndGetConnection();
            })
                ->isInstanceOf('Sly\NotificationPusher\Exception\RuntimeException')
        ;
    }

    public function testValidCertificatePassphrase() {
        $applePusher = new BaseApplePusher(array(
            'certificate' => __DIR__ . '/../../../fixtures/cert_with_passphrase.pem',
            'certificate_passphrase' => 'validpassphrase',
            'devices'     => array('ABC', 'DEF'),
        ));

        $con = $applePusher->initAndGetConnection();
        $this->assert
            ->boolean(is_resource($con))
                ->isTrue()
        ;
    }
}
