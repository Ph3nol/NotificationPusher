<?php

namespace Sly\NotificationPusher\Console;

use Symfony\Component\Console\Application as BaseApplication;
use Sly\NotificationPusher\NotificationPusher;
use Sly\NotificationPusher\Console\Command\PushCommand;

/**
 * Application.
 *
 * @uses \Symfony\Component\Console\Application
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Application extends BaseApplication
{
    /**
     * Constructor.
     */
    public function __construct()
    {
        error_reporting(-1);

        parent::__construct('NotificationPusher version', NotificationPusher::VERSION);

        $this->add(new PushCommand());
    }
}
