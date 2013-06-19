<?php

namespace Sly\NotificationPusher\Exception;

use Sly\NotificationPusher\Exception\ExceptionInterface;

/**
 * PushException.
 *
 * @uses   \RuntimeException
 * @uses   \Sly\NotificationPusher\Exception\ExceptionInterface
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushException extends \RuntimeException implements ExceptionInterface
{
}
