<?php

namespace Sly\NotificationPusher\Model;

interface MessageInterface
{
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
