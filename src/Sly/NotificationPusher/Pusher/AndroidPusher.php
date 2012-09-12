<?php

namespace Sly\NotificationPusher\Pusher;

use Sly\NotificationPusher\Pusher\BasePusher;
use Sly\NotificationPusher\Model\MessageInterface;
use Sly\NotificationPusher\Exception\ConfigurationException;
use Sly\NotificationPusher\Exception\RuntimeException;

use Buzz\Browser;
use Buzz\Client\Curl;

/**
 * AndroidPusher class.
 *
 * @uses BasePusher
 * @author Cédric Dugat <ph3@slynett.com>
 */
class AndroidPusher extends BasePusher
{
    const API_SERVER_HOST         = 'https://android.googleapis.com/gcm/send';
    const MAX_REGISTER_IDS_CHUNKS = 1000;

    protected $apiKey;

    /**
     * Constructor.
     *
     * @param array $config Configuration
     */
    public function __construct(array $config)
    {
        parent::__construct($config);

        if (empty($this->config['applicationID']) || null === $this->config['applicationID']) {
            throw new ConfigurationException('You must set a Google project application ID');
        }

        if (empty($this->config['apiKey']) || null === $this->config['apiKey']) {
            throw new ConfigurationException('You must set a Google account project API key');
        }

        $this->apiKey  = $this->config['apiKey'];

        if (count($this->getDevicesUUIDs()) > 1000) {
            throw new ConfigurationException('Devices UUIDs count cannot exceed 1000 entries');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function initAndGetConnection()
    {
        return new Browser(new Curl());
    }

    /**
     * {@inheritdoc}
     */
    public function pushMessage(MessageInterface $message)
    {
        $headers = array( 
            'Authorization: key=' . $this->config['apiKey'],
            'Content-Type: application/json',
        );

        $apiServerData = array(
            'data' => array(
                'message' => (string) $message,
            ),
        );

        $registrationIDsChunks = array_chunk($this->getDevicesUUIDs(), self::MAX_REGISTER_IDS_CHUNKS);
        $apiServerResponses    = array();

        foreach ($registrationIDsChunks as $registrationIDs) {
            $apiServerData['registration_ids'] = $registrationIDs;

            $apiServerResponse        = $this->getConnection()->post(self::API_SERVER_HOST, $headers, json_encode($apiServerData));
            $apiServerResponseHeaders = $apiServerResponse->getHeaders();

            if ('HTTP/1.1 401 Unauthorized' == $apiServerResponseHeaders[0]) {
                throw new ConfigurationException('Authorization problem, check your app parameters from your Google API Console');
            }

            $apiServerResponses[] = $apiServerResponse;
        }

        foreach ($apiServerResponses as $apiServerResponse) {
            $apiServerResponse = json_decode($apiServerResponse->getContent());

            if (true === (bool) $apiServerResponse->failure) {
                $apiServerErrors = array();

                foreach ($apiServerResponse->results as $result) {
                    $apiServerErrors[] = $result->error;
                }

                throw new RuntimeException(sprintf('API server has returned error(s): "%s"', implode(' / ', $apiServerErrors)));
            }
        }

        return true;
    }
}
