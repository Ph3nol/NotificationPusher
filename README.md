# NotificationPusher library

## WORK IN PROGRESS.

[![Continuous Integration status](https://secure.travis-ci.org/Ph3nol/NotificationPusher.png)](http://travis-ci.org/Ph3nol/NotificationPusher)

## Requirements

* PHP 5.3+

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
    'certificate' => '/path/to/your/certificate.pem',
));

/**
 * Add some test pushes.
 */
for ($i = 1; $i <= 3; $i++) {
    $message = new Message(sprintf('This is Test #%d', $i));
    // $message->setHasAlert(true);
    // $message->setHasBadge(true);
    // $message->setHasSound(true);

    $pusher->addMessage($message);
}

/**
 * Push queue.
 */
$pushedMessages = $pusher->push();
