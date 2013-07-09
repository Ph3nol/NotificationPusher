<?php

namespace Sly\NotificationPusher\Model;

/**
 * Device.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Device extends BaseParameteredModel
{
    /**
     * @var string
     */
    private $token;

    /**
     * Constructor.
     * 
     * @param string $token      Token
     * @param array  $parameters Parameters
     */
    public function __construct($token, array $parameters = array())
    {
        $this->token      = $token;
        $this->parameters = $parameters;
    }

    /**
     * Get token.
     *
     * @return string
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set token.
     *
     * @param string $token Token
     *
     * @return \Sly\NotificationPusher\Model\Device
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $this;
    }
}
