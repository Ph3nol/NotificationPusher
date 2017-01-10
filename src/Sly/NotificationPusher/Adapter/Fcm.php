<?php
namespace Sly\NotificationPusher\Adapter;

use Sly\NotificationPusher\Adapter\Fcm\Client;
use Sly\NotificationPusher\Adapter\Fcm\Message;
use Sly\NotificationPusher\Model\BaseOptionedModel;
use Sly\NotificationPusher\Model\MessageInterface;
use ZendService\Google\Gcm\Client as BaseClient;

class Fcm extends Gcm
{
    /**
     * Get opened client.
     *
     * @param  \ZendService\Google\Gcm\Client $client
     * @return Sly\NotificationPusher\Adapter\Fcm\Client
     */
    public function getOpenedClient()
    {
        return parent::getOpenedClient(new Client);
    }
    /**
     * Get service message from origin.
     *
     * @param  array $tokens
     * @param  \Sly\NotificationPusher\Model\BaseOptionedModel $message
     * @return Sly\NotificationPusher\Adapter\Fcm\Message
     */
    public function getServiceMessageFromOrigin(array $tokens, BaseOptionedModel $message)
    {
        $data = $message->getOptions();
        $data['message'] = $message->getText();
        $serviceMessage = new Message();
        $serviceMessage->setRegistrationIds($tokens)
            ->setData($data)
            ->setCollapseKey($this->getParameter('collapseKey'))
            ->setRestrictedPackageName($this->getParameter('restrictedPackageName'))
            ->setDelayWhileIdle($this->getParameter('delayWhileIdle', false))
            ->setTimeToLive($this->getParameter('ttl', 600))
            ->setDryRun($this->getParameter('dryRun', false))
            ->setPriority($this->getParameter('priority'));
        return $serviceMessage;
    }
    /**
     * Get the feedback.
     *
     * @return array
     */
    public function getFeedback()
    {
        return $this->response->getResults();
    }
}