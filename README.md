# NotificationPusher

Standalone PHP library for easy devices message notifications push.

[![Build Status](https://secure.travis-ci.org/Ph3nol/NotificationPusher.png)](http://travis-ci.org/Ph3nol/NotificationPusher)

## Requirements

* PHP 5.3+
* PHP Curl and OpenSSL modules
* Specific adapters requirements (like APNS certificate, GCM API key, etc.)

## Today available adapters

* APNS (Apple)
* GCM (Android)

## First basic push example (APNS one)

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter,
    Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push
;

// First, instanciate the manager.
// 
// Example for production environement:
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PRODUCTION);
// 
// Development one by default (without argument).
$pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

// Then declare an adapter.
$apnsAdapter = new ApnsAdapter(array(
    'certificate' => '/path/to/your/apns-certificate.pem',
));

// Set the device(s) to push the notification to.
$devices = new DeviceCollection(array(
    new Device('149cc24975da6c6b98605a8d268052ac0a214ec1e32110ab06f72b58401c1611'),
));

// Then, create the push skel.
$message = new Message('This is a basic example of push.');

// Finally, create and add the push to the manager, and push it!
$push = new Push($apnsAdapter, $devices, $message);
$pushManager->add($push);
$pushManager->push();
```

**For more examples and custom utilization, refer to the documentation below.**

## First basic feedback example (APNS one)

``` php
<?php

require_once '/path/to/vendor/autoload.php';

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Adapter\Apns as ApnsAdapter
;

// First, instanciate the manager.
// 
// Example for production environement:
// $pushManager = new PushManager(PushManager::ENVIRONMENT_PRODUCTION);
// 
// Development one by default (without argument).
$pushManager = new PushManager(PushManager::ENVIRONMENT_DEV);

// Then declare an adapter.
$apnsAdapter = new ApnsAdapter(array(
    'certificate' => '/path/to/your/apns-certificate.pem',
));

$feedback = $pushManager->getFeedback($apnsAdapter); // array of Token + DateTime couples
```

**For more examples and custom utilization, refer to the documentation below.**

## Documentation and examples

Soon.

## Todo

* Add new features
* Add new adapters (like Blackberry and Windows phones)
* Write more documentation and examples
* Write tests (hum... ASAP!)

## 1.x users

Old version is still available from [1.x branch](https://github.com/Ph3nol/NotificationPusher/tree/1.x), with dedicated declared tags.

Just base your Composer package version on `1.x` like this:

```
"sly/notification-pusher": "1.x"
```
