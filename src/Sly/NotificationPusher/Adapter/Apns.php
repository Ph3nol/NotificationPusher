<?php

namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Model\Push,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Exception\AdapterException,
    Sly\NotificationPusher\Exception\PushException,
    Sly\NotificationPusher\Collection\DeviceCollection
;

use ZendService\Apple\Apns\Client\AbstractClient as ServiceAbstractClient,
    ZendService\Apple\Apns\Client\Message as ServiceClient,
    ZendService\Apple\Apns\Message as ServiceMessage,
    ZendService\Apple\Apns\Message\Alert as ServiceAlert,
    ZendService\Apple\Apns\Response\Message as ServiceResponse,
    ZendService\Apple\Apns\Exception\RuntimeException as ServiceRuntimeException,
    ZendService\Apple\Apns\Client\Feedback as ServiceFeedbackClient,
    ZendService\Apple\Apns\Response\Feedback as ServiceFeedbackResponse
;

/**
 * APNS adapter.
 *
 * @uses \Sly\NotificationPusher\Adapter\BaseAdapter
 * @uses \Sly\NotificationPusher\Adapter\AdapterInterface
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Apns extends BaseAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\AdapterException
     */
    public function __construct(array $parameters = array())
    {
        parent::__construct($parameters);

        $cert = $this->getParameter('certificate');

        if (false === file_exists($cert)) {
            throw new AdapterException(sprintf('Certificate %s does not exist', $cert));
        }
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\PushException
     */
    public function push(Push $push)
    {
        $client = $this->getOpenedClient(new ServiceClient());

        $pushedDevices = new DeviceCollection();

        foreach ($push->getDevices() as $device) {
            $message = $this->getServiceMessageFromOrigin($device, $push->getMessage());

            try {
                $response = $client->send($message);
            } catch (ServiceRuntimeException $e) {
                throw new PushException($e->getMessage());
            }

            if (ServiceResponse::RESULT_OK === $response->getCode()) {
                $pushedDevices->add($device);
            }
        }

        $client->close();

        return $pushedDevices;
    }

    /**
     * Feedback.
     * 
     * @return array
     */
    public function getFeedback()
    {
        $client           = $this->getOpenedClient(new ServiceFeedbackClient());
        $responses        = array();
        $serviceResponses = $client->feedback();
        $client->close();

        foreach ($serviceResponses as $response) {
            $responses[$response->getToken()] = new \DateTime(date("c", $response->getTime()));
        }

        return $responses;
    }

    /**
     * Get opened client.
     *
     * @param \ZendService\Apple\Apns\Client\AbstractClient $client Client
     * 
     * @return \ZendService\Apple\Apns\Client\AbstractClient
     */
    public function getOpenedClient(ServiceAbstractClient $client)
    {
        $client->open(
            $this->isProductionEnvironment() ? ServiceClient::PRODUCTION_URI : ServiceClient::SANDBOX_URI,
            $this->getParameter('certificate'),
            $this->getParameter('passPhrase')
        );

        return $client;
    }

    /**
     * Get service message from origin.
     * 
     * @param \Sly\NotificationPusher\Model\Device  $device Device
     * @param \Sly\NotificationPusher\Model\Message $message Message
     * 
     * @return \ZendService\Apple\Apns\Message
     */
    public function getServiceMessageFromOrigin(Device $device, Message $message)
    {
        $badge = ($message->hasOption('badge'))
            ? (int) ($message->getOption('badge') + $device->getParameter('badge', 0))
            : 0
        ;

        $sound = $message->getOption('sound', 'bingbong.aiff');

        $serviceMessage = new ServiceMessage();
        $serviceMessage->setId(sha1($device->getToken().$message->getText()));
        $serviceMessage->setAlert($message->getText());
        $serviceMessage->setToken($device->getToken());
        $serviceMessage->setBadge($badge);

        if (null !== $sound) {
            $serviceMessage->setSound($sound);
        }

        return $serviceMessage;
    }

    /**
     * {@inheritdoc}
     */    
    public function supports($token)
    {
        return (ctype_xdigit($token) && 64 == strlen($token));
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array('passPhrase' => null);
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        return array('certificate');
    }
}
