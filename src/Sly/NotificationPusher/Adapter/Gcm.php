<?php

namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Model\Push,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Collection\DeviceCollection
;

use ZendService\Google\Gcm\Client as ServiceClient,
    ZendService\Google\Gcm\Message as ServiceMessage,
    ZendService\Google\Exception\RuntimeException as ServiceRuntimeException
;

/**
 * GCM adapter.
 *
 * @uses \Sly\NotificationPusher\Adapter\BaseAdapter
 * @uses \Sly\NotificationPusher\Adapter\AdapterInterface
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends BaseAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */    
    public function supports($token)
    {
        return (bool) preg_match('/[0-9a-zA-Z\-\_]/i', $token);
    }

    /**
     * {@inheritdoc}
     *
     * @throws \Sly\NotificationPusher\Exception\PushException
     */
    public function push(Push $push)
    {
        $client        = $this->getOpenedClient(new ServiceClient());
        $pushedDevices = new DeviceCollection();
        $tokens        = array_chunk($push->getDevices()->getTokens(), 100);

        foreach ($tokens as $tokensRange) {
            $message = $this->getServiceMessageFromOrigin($tokensRange, $push->getMessage());

            try {
                $response = $client->send($message);
            } catch (ServiceRuntimeException $e) {
                throw new PushException($e->getMessage());
            }

            if ((bool) $response->getSuccessCount()) {
                foreach ($tokensRange as $token) {
                    $pushedDevices->add($push->getDevices()->get($token));
                }
            }
        }

        return $pushedDevices;
    }

    /**
     * Get opened client.
     *
     * @param \ZendService\Google\Gcm\Client $client Client
     * 
     * @return \ZendService\Google\Gcm\Client
     */
    public function getOpenedClient(ServiceClient $client)
    {
        $client->setApiKey($this->getParameter('apiKey'));

        return $client;
    }

    /**
     * Get service message from origin.
     * 
     * @param array                                 $tokens  Tokens
     * @param \Sly\NotificationPusher\Model\Message $message Message
     * 
     * @return \ZendService\Google\Gcm\Message
     */
    public function getServiceMessageFromOrigin(array $tokens = array(), Message $message)
    {
        $serviceMessage = new ServiceMessage();
        $serviceMessage->setRegistrationIds($tokens);
        $serviceMessage->setData($message->getOptions());
        $serviceMessage->setCollapseKey($this->getParameter('collapseKey'));
        $serviceMessage->setRestrictedPackageName($this->getParameter('restrictedPackageName'));
        $serviceMessage->setDelayWhileIdle($this->getParameter('delayWhileIdle', false));
        $serviceMessage->setTimeToLive($this->getParameter('ttl', 600));
        $serviceMessage->setDryRun($this->getParameter('dryRun', false));

        return $serviceMessage;
    }

    /**
     * {@inheritdoc}
     */
    public function getDefaultParameters()
    {
        return array();
    }

    /**
     * {@inheritdoc}
     */
    public function getRequiredParameters()
    {
        return array('apiKey');
    }
}
