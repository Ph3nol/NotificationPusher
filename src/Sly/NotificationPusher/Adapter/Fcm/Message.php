<?php

namespace Sly\NotificationPusher\Adapter\Fcm;

use Zend\Json\Json;
use ZendService\Google\Gcm\Message as BaseMessage;

class Message extends BaseMessage
{
    /**
     * @var string
     */
    const PRIORITY_HIGH = 'high';
    /**
     * @var string
     */
    const PRIORITY_NORMAL = 'normal';
    /**
     * @var string
     */
    protected $priority;
    /**
     * Set the priority.
     *
     * @param  string $priority
     * @return $this
     */
    public function setPriority($priority)
    {
        $priority = in_array($priority, [static::PRIORITY_HIGH, static::PRIORITY_NORMAL]) ? $priority : static::PRIORITY_NORMAL;
        $this->priority = $priority;
        return $this;
    }
    /**
     * Get priority.
     *
     * @return string
     */
    public function getPriority()
    {
        return $this->priority;
    }
    /**
     * {@inheritdoc}
     */
    public function toJson()
    {
        $json = parent::toJson();
        $data = Json::decode($json, Json::TYPE_ARRAY);
        if ($this->priority) {
            $data['priority'] = $this->priority;
        }
        return Json::encode($data);
    }
}