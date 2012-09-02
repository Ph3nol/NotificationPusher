<?php

namespace Sly\NotificationPusher\Exception;

use Sly\NotificationPusher\Exception\Exception;

/**
 * ConfigurationException.
 *
 * @uses InvalidArgumentException
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ConfigurationException extends \InvalidArgumentException implements Exception
{
}
