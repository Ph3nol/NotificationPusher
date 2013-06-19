<?php

namespace Sly\NotificationPusher\Exception;

use Sly\NotificationPusher\Exception\ExceptionInterface;

/**
 * AdapterException.
 *
 * @uses   \RuntimeException
 * @uses   \Sly\NotificationPusher\Exception\ExceptionInterface
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
class AdapterException extends \RuntimeException implements ExceptionInterface
{
}
