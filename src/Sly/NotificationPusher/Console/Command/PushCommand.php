<?php

namespace Sly\NotificationPusher\Console\Command;

use Symfony\Component\Console\Command\Command,
    Symfony\Component\Console\Input\InputArgument,
    Symfony\Component\Console\Input\InputInterface,
    Symfony\Component\Console\Input\InputOption,
    Symfony\Component\Console\Output\OutputInterface
;

use Sly\NotificationPusher\PushManager,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Push,
    Sly\NotificationPusher\Exception\AdapterException
;

use Doctrine\Common\Util\Inflector;

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
            ->setDescription('Manual notification push')
            ->addArgument(
                'adapter',
                InputArgument::REQUIRED,
                'Adapter (apns, gcm, specific class name, ...)'
            )
            ->addArgument(
                'token',
                InputArgument::REQUIRED,
                'Device Token or Registration ID'
            )
            ->addArgument(
                'message',
                InputArgument::REQUIRED,
                'Message'
            )
            ->addOption(
                'certificate',
                null,
                InputOption::VALUE_OPTIONAL,
                'Certificate path (for APNS adapter)'
            )
            ->addOption(
                'api-key',
                null,
                InputOption::VALUE_OPTIONAL,
                'API key (for GCM adapter)'
            )
            ->addOption(
                'env',
                PushManager::ENVIRONMENT_DEV,
                InputOption::VALUE_OPTIONAL,
                sprintf(
                    'Environment (%s, %s)',
                    PushManager::ENVIRONMENT_DEV,
                    PushManager::ENVIRONMENT_PROD
                )
            );
    }

    /**
     * {@inheritdoc}
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $adapter     = $this->getReadyAdapter($input, $output);
        $pushManager = new PushManager($input->getOption('env'));
        $message     = new Message('This is an example.');
        $push        = new Push($adapter, new Device($input->getArgument('token')), $message);
        $pushManager->add($push);

        $pushes = $pushManager->push();
    }

    /**
     * Get adapter class from argument.
     *
     * @param string $argument Given argument
     *
     * @return string
     */
    private function getAdapterClassFromArgument($argument)
    {
        if (
            !class_exists($adapterClass = $argument) &&
            !class_exists($adapterClass = '\\Sly\\NotificationPusher\\Adapter\\'.ucfirst($argument))
        ) {
            throw new AdapterException(
                sprintf(
                    'Adapter class %s does not exist',
                    $adapterClass
                )
            );
        }

        return $adapterClass;
    }

    /**
     * {@inheritdoc}
     *
     * @return \Sly\NotificationPusher\Adapter\AdapterInterface
     */
    private function getReadyAdapter(InputInterface $input, OutputInterface $output)
    {
        $adapterClass = $this->getAdapterClassFromArgument($input->getArgument('adapter'));

        try {
            $adapter = new $adapterClass();
        } catch (\Exception $e) {
            $adapterData = array();
            preg_match_all('/"(.*)"/i', $e->getMessage(), $matches);

            foreach ($matches[1] as $match) {
                $optionKey = str_replace('_', '-', Inflector::tableize($match));
                $option    = $input->getOption($optionKey);

                if (!$option) {
                    throw new AdapterException(
                        sprintf(
                            'The option "%s" is needed by %s adapter',
                            $optionKey,
                            $adapterClass
                        )
                    );
                }

                $adapterData[$match] = $option;
            }

            $adapter = new $adapterClass($adapterData);
        }

        return $adapter;
    }
}
