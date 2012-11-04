<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusher;
use Sly\NotificationPusher\Model\MessageInterface;
use Sly\NotificationPusher\Exception\ConfigurationException;
use Sly\NotificationPusher\Exception\RuntimeException;

/**
 * ApplePusher class.
 *
 * @uses BasePusher
 * @author Cédric Dugat <ph3@slynett.com>
 */
class ApplePusher extends BasePusher
{
    const TTL                               = 3600;
    const APNS_SERVER_HOST                  = 'ssl://gateway.push.apple.com:2195';
    const APNS_SANDBOX_SERVER_HOST          = 'ssl://gateway.sandbox.push.apple.com:2195';
    const APNS_FEEDBACK_SERVER_HOST         = 'ssl://feedback.push.apple.com:2196';
    const APNS_FEEDBACK_SANDBOX_SERVER_HOST = 'ssl://feedback.sandbox.push.apple.com:2196';

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (empty($this->config['certificate']) || null === $this->config['certificate']) {
            throw new ConfigurationException('You must set a SSL certificate to establish the connection');
        }

        if (false === file_exists($this->config['certificate'])) {
            throw new ConfigurationException('Given Apple certificate cannot be found');
        }
    }

    /**
     * Get APNS server host.
     * 
     * @return string
     */
    protected function getApnsServerHost()
    {
        if ($this->config['feedback']) {
            return true === $this->config['dev'] ?
                self::APNS_FEEDBACK_SANDBOX_SERVER_HOST : self::APNS_FEEDBACK_SERVER_HOST;
        } else {
            return true === $this->config['dev'] ?
                self::APNS_SANDBOX_SERVER_HOST : self::APNS_SERVER_HOST;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initAndGetConnection()
    {
        $ctx = stream_context_create();

        stream_context_set_option($ctx, 'ssl', 'local_cert', $this->config['certificate']);

        $connection = stream_socket_client(
            $this->getApnsServerHost(),
            $error,
            $errorString,
            100,
            (STREAM_CLIENT_CONNECT|STREAM_CLIENT_PERSISTENT),
            $ctx
        );

        if (false === $connection) {
            throw new RuntimeException(sprintf('Failed to establish APNS connection: %s', $errorString));
        }

        return $connection;
    }

    /**
     * Get feedback to list all tokens to unregister (not used anymore).
     *
     * @return array
     */
    public function getFeedback()
    {
        $feedbackResponses = array();

        while ($fbCon = fread($this->getConnection(), 38)) {
            $arr    = unpack("H*", $fbCon);
            $rawhex = trim(implode("", $arr));
            $token  = substr($rawhex, 12, 64);

            if (!empty($token)) {
                $feedbackResponses[] = sprintf('Token was not registered anymore: %s', $token);
            }
        }

        fclose($this->getConnection());

        return $feedbackResponses;
    }

    /**
     * {@inheritdoc}
     */
    public function pushMessage(MessageInterface $message)
    {
        $apiServerResponses = array();

        foreach ($this->getDevicesUUIDs() as $deviceToken) {
            $payload = $this->getPayloadFromMessage($message);

            if (null !== $payload) {
                $packedMessage = $this->getPackedMessage($message, $deviceToken, $payload);

                $apiServerResponses[] = fwrite($this->getConnection(), $packedMessage);
            }
        }

        foreach ($apiServerResponses as $apiServerResponse) {
            /**
             * @todo Check response and throw adapted needed exceptions.
             */
        }


        return true;
    }

    /**
     * Get payload from message.
     * 
     * @param MessageInterface $message Message
     * 
     * @return array|null
     */
    private function getPayloadFromMessage(MessageInterface $message)
    {
        if (true === $message->hasAlert()) {
            $payload['aps']['alert'] = is_array($message->getAlert()) ? $message->getAlert() : (string) $message;
        }

        $payload['aps']['badge'] = (int) $message->getBadge();
        $payload['aps']['sound'] = $message->getSound();

        return isset($payload) ? json_encode($payload) : null;
    }

    /**
     * Get packed message.
     * 
     * @param MessageInterface $message     Message
     * @param string           $deviceToken Device token
     * @param string           $payload     Payload
     * 
     * @return array|null
     */
    private function getPackedMessage(MessageInterface $message, $deviceToken, $payload = null)
    {
        if ($payload) {
            return chr(0) . chr(0) . chr(32) . pack('H*', str_replace(' ', '', $deviceToken))
                . chr(0) . chr(strlen($payload)) . $payload;
        } else {
            return null;
        }
    }
}
