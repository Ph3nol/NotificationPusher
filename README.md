# NotificationPusher

Standalone PHP library for easy devices message notifications push.

[![Latest Stable Version](https://poser.pugx.org/sly/notification-pusher/v/stable.png)](https://packagist.org/packages/sly/notification-pusher)
[![Total Downloads](https://poser.pugx.org/sly/notification-pusher/downloads.png)](https://packagist.org/packages/sly/notification-pusher)
[![Build Status](https://secure.travis-ci.org/Ph3nol/NotificationPusher.png)](http://travis-ci.org/Ph3nol/NotificationPusher)

**Feel free to contribute! Thanks.**

## Requirements

* PHP 5.3+
* PHP Curl and OpenSSL modules
* Specific adapters requirements (like APNS certificate, GCM API key, etc.)

## Today available adapters

* APNS (Apple)
* GCM (Android)

## Documentation and examples

* [Installation](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/installation.md)
* [Getting started](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/getting-started.md)
* [APNS adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/apns-adapter.md)
* [GCM adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/gcm-adapter.md)
* [Create an adapter](https://github.com/Ph3nol/NotificationPusher/blob/master/doc/create-an-adapter.md)

## Todo

* Add new features (custom APNS payloads, GCM custom options, etc.)
* Add new adapters (like Blackberry and Windows phones)
* Write more documentation and examples
* Write tests (hum... ASAP!)

## 1.x users

Old version is still available from [1.x branch](https://github.com/Ph3nol/NotificationPusher/tree/1.x), with dedicated declared tag.

Just base your Composer package version on `1.x` like this:

```
"sly/notification-pusher": "1.x"
```
