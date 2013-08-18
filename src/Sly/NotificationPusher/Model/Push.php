<?php

namespace Sly\NotificationPusher\Model;

use Sly\NotificationPusher\Collection\DeviceCollection;
use Sly\NotificationPusher\Adapter\AdapterInterface;
use Sly\NotificationPusher\Model\Device;
use Sly\NotificationPusher\Model\Message;
use Sly\NotificationPusher\Exception\AdapterException;

/**
 * Push.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends BaseOptionedModel
{
    const STATUS_PENDING = 'pending';
    const STATUS_PUSHED  = 'sent';

    /**
     * @var string
     */
    private $status;

    /**
     * @var \Sly\NotificationPusher\Adapter\AdapterInterface
     */
    private $adapter;

    /**
     * @var \Sly\NotificationPusher\Model\Message
     */
    private $message;

    /**
     * @var \Sly\NotificationPusher\Collection\DeviceCollection
     */
    private $devices;

    /**
     * @var \DateTime
     */
    private $pushedAt;

    /**
     * Constructor.
     *
     * @param \Sly\NotificationPusher\Adapter\AdapterInterface  $adapter Adapter
     * @param Device|DeviceCollection                           $devices Device(s)
     * @param \Sly\NotificationPusher\Model\Message             $message Message
     * @param array                                             $options Options
     *
     * Options are adapters specific ones, like Apns "badge" or "sound" option for example.
     * Of course, they can be more general.
     *
     * @throws \Sly\NotificationPusher\Exception\AdapterException
     */
    public function __construct(AdapterInterface $adapter, $devices, Message $message, array $options = array())
    {
        if ($devices instanceof Device) {
            $devices = new DeviceCollection(array($devices));
        }

        $this->adapter = $adapter;
        $this->devices = $devices;
        $this->message = $message;
        $this->options = $options;
        $this->status  = self::STATUS_PENDING;

        $this->checkDevicesTokens();
    }

    /**
     * Check devices tokens.
     */
    private function checkDevicesTokens()
    {
        $devices = $this->getDevices();
        $adapter = $this->getAdapter();

        foreach ($devices as $device) {
            if (false === $adapter->supports($device->getToken())) {
                throw new AdapterException(
                    sprintf(
                        'Adapter %s does not supports %s token\'s device',
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
     * @return \Sly\NotificationPusher\Model\Push
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
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function pushed()
    {
        $this->status   = self::STATUS_PUSHED;
        $this->pushedAt = new \DateTime();

        return $this;
    }

    /**
     * Get Adapter.
     *
     * @return \Sly\NotificationPusher\Adapter\AdapterInterface
     */
    public function getAdapter()
    {
        return $this->adapter;
    }

    /**
     * Set Adapter.
     *
     * @param \Sly\NotificationPusher\Adapter\AdapterInterface $adapter Adapter
     *
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function setAdapter(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;

        return $this;
    }

    /**
     * Get Message.
     *
     * @return \Sly\NotificationPusher\Model\Message
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set Message.
     *
     * @param \Sly\NotificationPusher\Model\Message $message Message
     *
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function setMessage(Message $message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get Devices.
     *
     * @return \Sly\NotificationPusher\Collection\DeviceCollection
     */
    public function getDevices()
    {
        return $this->devices;
    }

    /**
     * Set Devices.
     *
     * @param \Sly\NotificationPusher\Collection\DeviceCollection $devices Devices
     *
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function setDevices(DeviceCollection $devices)
    {
        $this->devices = $devices;

        $this->checkDevicesTokens();

        return $this;
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
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function setPushedAt(\DateTime $pushedAt)
    {
        $this->pushedAt = $pushedAt;

        return $this;
    }
}
