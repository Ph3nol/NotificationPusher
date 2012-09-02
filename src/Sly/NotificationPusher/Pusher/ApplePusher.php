<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusher;
use Sly\NotificationPusher\Model\MessageInterface;

/**
 * ApplePusher class.
 *
 * @uses BasePusher
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ApplePusher extends BasePusher
{
    const TTL                      = 3600;
    const APNS_SERVER_HOST         = 'ssl://gateway.push.apple.com:2195';
    const APNS_SANDBOX_SERVER_HOST = 'ssl://gateway.sandbox.push.apple.com:2195';

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (empty($this->config['certificate']) || null === $this->config['certificate']) {
            throw new \Exception('You must set a SSL certificate to establish the connection');
        }
    }

    /**
     * Get APNS server host.
     * 
     * @return string
     */
    protected function getApnsServerHost()
    {
        return true === $this->config['dev'] ? self::APNS_SANDBOX_SERVER_HOST : self::APNS_SERVER_HOST;
    } 

    /**
     * {@inheritdoc}
     */
    public function initAndGetConnection()
    {
        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config['certificate']);
        
        $connection = stream_socket_client($this->getApnsServerHost(), $error, $errorString, 100, (STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT), $ctx);

        if (false === $connection) {
            throw new \RuntimeException(sprintf('Failed to establish APNS connection: %s', $errorString));
        }

        return $connection;
    }

    /**
     * {@inheritdoc}
     */
    public function pushMessage(MessageInterface $message)
    {
        return (bool) fwrite($this->getConnection(), $message->getMessage());
    }
}
