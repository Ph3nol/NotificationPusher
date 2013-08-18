<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Model\Push;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Collection\DeviceCollection;

use ZendService\Google\Gcm\Client as ServiceClient;
use ZendService\Google\Gcm\Message as ServiceMessage;
use ZendService\Google\Exception\RuntimeException as ServiceRuntimeException;

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
    public function getServiceMessageFromOrigin(array $tokens, Message $message)
    {
        $data            = $message->getOptions();
        $data['message'] = $message->getText();

        $serviceMessage = new ServiceMessage();
        $serviceMessage->setRegistrationIds($tokens);
        $serviceMessage->setData($data);
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
