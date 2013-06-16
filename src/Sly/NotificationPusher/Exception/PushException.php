<?php

namespace Sly\NotificationPusher\Exception;

use Sly\NotificationPusher\Exception\Exception;

/**
 * PushException.
 *
 * @uses   \RuntimeException
 * @uses   \Sly\NotificationPusher\Exception\Exception
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushException extends \RuntimeException implements Exception
{
}
