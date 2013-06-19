<?php

namespace Sly\NotificationPusher\Model;

/**
 * Message.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Message extends BaseOptionedModel
{
    /**
     * @var string
     */
    private $text;

    /**
     * Constructor.
     * 
     * @param string $text    Text
     * @param array  $options Options
     */
    public function __construct($text, array $options = array())
    {
        $this->text    = $text;
        $this->options = $options;
    }

    /**
     * Get Text.
     *
     * @return string
     */
    public function getText()
    {
        return $this->text;
    }

    /**
     * Set Text.
     *
     * @param string $text Text
     *
     * @return \Sly\NotificationPusher\Model\Message
     */
    public function setText($text)
    {
        $this->text = $text;

        return $this;
    }
}
