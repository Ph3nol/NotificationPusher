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
      * @return string Status value to get
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
      * @return string Message value to get
      */
    public function getMessage();
    
    /**
      * Set Message value.
      *
      * @param string $message Message value to set
      */
    public function setMessage($message);

    /**
      * Get HasAlert value.
      *
      * @return boolean HasAlert value to get
      */
    public function getHasAlert();

    /**
      * Get HasAlert value.
      *
      * @return boolean HasAlert value to get
      */
    public function hasAlert();
    
    /**
      * Set HasAlert value.
      *
      * @param boolean  $hasAlert HasAlert value to set
      */
    public function setHasAlert($hasAlert);

    /**
      * Get HasBadge value.
      *
      * @return boolean HasBadge value to get
      */
    public function getHasBadge();

    /**
      * Get HasBadge value.
      *
      * @return boolean HasBadge value to get
      */
    public function hasBadge();
    
    /**
      * Set HasBadge value.
      *
      * @param boolean $hasBadge HasBadge value to set
      */
    public function setHasBadge($hasBadge);

    /**
      * Get HasSound value.
      *
      * @return boolean HasSound value to get
      */
    public function getHasSound();

    /**
      * Get HasSound value.
      *
      * @return boolean HasSound value to get
      */
    public function hasSound();
    
    /**
      * Set HasSound value.
      *
      * @param boolean $hasSound HasSound value to set
      */
    public function setHasSound($hasSound);

    /**
      * Get CreatedAt value.
      *
      * @return \DateTime CreatedAt value to get
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
      * @return \DateTime SentAt value to get
      */
    public function getSentAt();
    
    /**
      * Set SentAt value.
      *
      * @param \DateTime $sentAt SentAt value to set
      */
    public function setSentAt(\DateTime $sentAt);
}
