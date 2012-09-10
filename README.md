# NotificationPusher

PHP library for easy Apple/Android notification message pushing.

## WORK IN PROGRESS.

[![Continuous Integration status](https://secure.travis-ci.org/Ph3nol/NotificationPusher.png)](http://travis-ci.org/Ph3nol/NotificationPusher)

## Requirements

* PHP 5.3+
* PHP Curl extension - +SSL support (for AndroidPusher service)
* PHP OpenSSL extension (for ApplePusher service)

## Installation

### Add to your project Composer packages

Just add `sly/notification-pusher` package to the requirements of your Composer JSON configuration file,
and run `php composer.phar install` to install it.

### Install from GitHub

Clone this library from Git with `git clone https://github.com/Ph3nol/NotificationPusher.git`.

Goto to the library directory, get Composer phar package and install vendors:

```
curl -s https://getcomposer.org/installer | php
php composer.phar install
```

You're ready to go.

## Example

### Apple push (iPhone / iPad)

* Requirements: create a developer SSL certificate for your application

``` php
<?php

require_once '/path/to/your/vendor/autoload.php';

use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Pusher\ApplePusher;

/**
 * Initialize Apple pusher service.
 */
$pusher = new ApplePusher(array(
    'dev'         => true,                             // Developer/Sandbox mode enabled (default: false)
    'simulate'    => false,                            // Simulate sendings (default: false)
    'certificate' => '/path/to/your/certificate.pem',
    'devices'     => array('UUID1', 'UUID2', 'UUID3'), // Devices UUIDs (Apple Device Tokens)
));

/**
 * Add some test pushes.
 */
for ($i = 1; $i <= 3; $i++) {
    $message = new Message(sprintf('This is Test #%d', $i));
    // $message->setAlert(false);           // Don't display message
    // $message->setBadge(999);             // Display '999' badge
    // $message->setSound('bingbong.aiff'); // Set specific sound

    $pusher->addMessage($message);
}

/**
 * Push queue.
 */
$pushedMessages = $pusher->push();

```

### Android push

* Requirements: get a Google account project API key

``` php
<?php

require_once '/path/to/your/vendor/autoload.php';

use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Pusher\AndroidPusher;

/**
 * Initialize Android pusher service.
 */
$pusher = new AndroidPusher(array(
    'applicationID' => '123456789012', // Your Google project application ID
    'apiKey'        => 'y0ur4p1k3y',   // Your Google account project API key
    'devices'       => array('UUID1', 'UUID2', 'UUID3'), // Devices UUIDs (Register IDs)
));

/**
 * Add some test pushes.
 */
for ($i = 1; $i <= 3; $i++) {
    $message = new Message(sprintf('This is Test #%d', $i));
    // $message->setAlert(false);           // Don't display message
    // $message->setBadge(999);             // Display '999' badge
    // $message->setSound('bingbong.aiff'); // Set specific sound

    $pusher->addMessage($message);
}

/**
 * Push queue.
 */
$pushedMessages = $pusher->push();

```

## Test with Atoum

This library is using [https://github.com/mageekguy/atoum](Atoum) for unit testing,
whose Composer package can be installed with `dev` mode:

```
php composer install --dev
./atoum -d tests/units
```

## Complements

### Create Apple SSL certificate

Getting the certificates in place. Reach for your mac and start doing the following:

* 1. Login to iPhone Developer Connection Portal and click on App Ids.
* 2. Create an AppId for your application withouth a wildcard. It should be something like this: **com.vxtindia.PushSample**.
* 3. Click on configure and then go ahead and create a certificate for Push Notifications. Download it once it has been created.
* 4. Import the newly created certificate into your keychain by double clicking it.
* 5. Launch "Keychain Assistant" and filter it by the Certificate's category. Then you should see a "Apple Development Push Services" option. Expand it, right click on it, click on "Export..." and save this as **apns-dev-cert.p12**. Also download the private key as **apns-dev-key.p12**.
* 6. Copy **apns-dev-cert.p12** file to your server source code folder.
* 7. Now run `openssl pkcs12 -clcerts -nokeys -out apns-dev-cert.pem -in apns-dev-cert.p12` and `openssl pkcs12 -nocerts -out apns-dev-key.pem -in apns-dev-key.p12` on your server.
* 8. From Ubuntu-9.04 server, we had to remove the passphrase, which can be done with `openssl rsa -in apns-dev-key.pem -out apns-dev-key-noenc.pem`.
* 9. Finally, combine the two to get your **apns-dev.pem file**: `cat apns-dev-cert.pem apns-dev-key-noenc.pem > apns-dev.pem`.

Source: [http://vxtindia.com/blog/push-notifications-for-your-iphone-app-with-php-and-ubuntu/](http://vxtindia.com/blog/push-notifications-for-your-iphone-app-with-php-and-ubuntu/)

### Create a Google account project ID and API key

* 1. Go on [https://code.google.com/apis/console](Google APIs console dashboard)
* 2. Create a new projet
* 3. You are now on your new project homepage, with a URL like `https://code.google.com/apis/console/#project:123456789012`. `123456789012` is your application ID.
* 4. Click "Api Access" tab to obtain your API key