<?php

namespace Sly\NotificationPusher\Console\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

/**
 * PushCommand.
 *
 * @uses \Symfony\Component\Console\Command\Command
 * @author Cédric Dugat <cedric@dugat.me>
 */
class PushCommand extends Command
{
    /**
     * @see Command
     */
    protected function configure()
    {
        parent::configure();

        $this
            ->setName('push')
            ->setDescription('Manual notification push');
    }

    /**
     * @see Command
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
    }
}
