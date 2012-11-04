<?php

namespace Sly\NotificationPusher\Model;

interface MessageInterface
{
    const STATUS_INIT           = 'initialized';
    const STATUS_PENDING        = 'pending';
    const STATUS_SENT           = 'sent';
    const STATUS_SIMULATED_SENT = 'simulated-sent';
    const STATUS_FAILED         = 'failed';

    /**
      * Get Status value.
      *
      * @return string
      */
    public function getStatus();

    /**
      * Set Status value.
      *
      * @param string $status Status value to set
      */
    public function setStatus($status);

    /**
      * Get sent statuses.
      *
      * @return array
      */
    public function getSentStatuses();

    /**
      * Get Message value.
      *
      * @return string
      */
    public function getMessage();

    /**
      * Set Message value.
      *
      * @param string $message Message value to set
      */
    public function setMessage($message);

    /**
      * Returns if message has an alert or not.
      * Consider alert as push message.
      *
      * @return boolean
      */
    public function hasAlert();

    /**
      * Get alert value.
      * 
      * @return boolean|array
      */
    public function getAlert();

    /**
      * Set if message has to be displayed with push.
      * Set specific alert (array) if needed.
      *
      * @param boolean|array $alert Alert value to set
      */
    public function setAlert($alert);

    /**
      * Get badge value.
      *
      * @return boolean
      */
    public function getBadge();

    /**
      * Set badge value.
      *
      * @param integer $badge Badge value to set
      */
    public function setBadge($badge);

    /**
      * Get Sound value.
      *
      * @return string
      */
    public function getSound();

    /**
      * Set sound value.
      *
      * @param string $hasSound Sound value to set
      */
    public function setSound($sound);

    /**
      * Get CreatedAt value.
      *
      * @return \DateTime
      */
    public function getCreatedAt();

    /**
      * Set CreatedAt value.
      *
      * @param \DateTime $createdAt CreatedAt value to set
      */
    public function setCreatedAt(\DateTime $createdAt);

    /**
      * Get SentAt value.
      *
      * @return \DateTime
      */
    public function getSentAt();

    /**
      * Set SentAt value.
      *
      * @param \DateTime $sentAt SentAt value to set
      */
    public function setSentAt(\DateTime $sentAt);
}
