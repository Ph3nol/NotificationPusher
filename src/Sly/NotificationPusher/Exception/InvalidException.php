<?php

namespace Sly\NotificationPusher\Exception;

use Sly\NotificationPusher\Exception\ExceptionInterface;

/**
 * InvalidException.
 *
 * @uses   \RuntimeException
 * @uses   \Sly\NotificationPusher\Exception\ExceptionInterface
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
class InvalidException extends \RuntimeException implements ExceptionInterface
{
}
