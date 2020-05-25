<?php

/*
 * This file is part of NotificationPusher.
 *
 * (c) 2013 Cédric Dugat <cedric@dugat.me>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Sly\NotificationPusher\Model;

use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Collection\ResponseCollection;
use Sly\NotificationPusher\Exception\AdapterException;

/**
 * Push.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends BaseOptionedModel implements PushInterface
{

    /**
     * @var string
     */
    private $status;

    /**
     * @var AdapterInterface
     */
    private $adapter;

    /**
     * @var MessageInterface
     */
    private $message;

    /**
     * @var DeviceCollection
     */
    private $devices;

    /**
     * @var \DateTime
     */
    private $pushedAt;

    /**
     * @var ResponseCollection
     */
    private $responses;

    /**
     * Constructor.
     *
     * @param AdapterInterface $adapter Adapter
     * @param DeviceInterface|DeviceCollection $devices Device(s)
     * @param MessageInterface $message Message
     * @param array $options Options
     *
     * Options are adapters specific ones, like Apns "badge" or "sound" option for example.
     * Of course, they can be more general.
     *
     * @throws AdapterException
     */
    public function __construct(AdapterInterface $adapter, $devices, MessageInterface $message, array $options = [])
    {
        if ($devices instanceof DeviceInterface) {
            $devices = new DeviceCollection([$devices]);
        }

        $this->adapter = $adapter;
        $this->devices = $devices;
        $this->message = $message;
        $this->options = $options;
        $this->status = self::STATUS_PENDING;

        $this->checkDevicesTokens();
    }

    /**
     * Check devices tokens.
     * @throws AdapterException
     */
    private function checkDevicesTokens()
    {
        $devices = $this->getDevices();
        $adapter = $this->getAdapter();

        foreach ($devices as $device) {
            if (false === $adapter->supports($device->getToken())) {
                throw new AdapterException(
                    sprintf(
                        'Adapter %s does not support %s token\'s device',
                        (string) $adapter,
                        $device->getToken()
                    )
                );
            }
        }
    }

    /**
     * Get Status.
     *
     * @return string
     */
    public function getStatus()
    {
        return $this->status;
    }

    /**
     * Set Status.
     *
     * @param string $status Status
     *
     * @return PushInterface
     */
    public function setStatus($status)
    {
        $this->status = $status;

        return $this;
    }

    /**
     * isPushed.
     *
     * @return boolean
     */
    public function isPushed()
    {
        return (bool) (self::STATUS_PUSHED === $this->status);
    }

    /**
     * Declare as pushed.
     *
     * @return PushInterface
     */
    public function pushed()
    {
        $this->status = self::STATUS_PUSHED;
        $this->pushedAt = new \DateTime();

        return $this;
    }

    /**
     * Get Adapter.
     *
     * @return AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set Adapter.
     *
     * @param AdapterInterface $adapter Adapter
     *
     * @return PushInterface
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get Message.
     *
     * @return MessageInterface
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set Message.
     *
     * @param MessageInterface $message Message
     *
     * @return PushInterface
     */
    public function setMessage(MessageInterface $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get Devices.
     *
     * @return DeviceCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Set Devices.
     *
     * @param DeviceCollection $devices Devices
     *
     * @return PushInterface
     */
    public function setDevices(DeviceCollection $devices)
    {
        $this->devices = $devices;

        $this->checkDevicesTokens();

        return $this;
    }

    /**
     * Get Responses
     * @return ResponseCollection
     */
    public function getResponses()
    {
        if (!$this->responses)
            $this->responses = new ResponseCollection();

        return $this->responses;
    }

    /**
     * adds a response
     * @param DeviceInterface $device
     * @param mixed $response
     */
    public function addResponse(DeviceInterface $device, $response)
    {
        $this->getResponses()->add($device->getToken(), $response);
    }

    /**
     * Get PushedAt.
     *
     * @return \DateTime
     */
    public function getPushedAt()
    {
        return $this->pushedAt;
    }

    /**
     * Set PushedAt.
     *
     * @param \DateTime $pushedAt PushedAt
     *
     * @return PushInterface
     */
    public function setPushedAt(\DateTime $pushedAt)
    {
        $this->pushedAt = $pushedAt;

        return $this;
    }
}
