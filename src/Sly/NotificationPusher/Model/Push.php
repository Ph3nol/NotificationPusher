<?php

namespace Sly\NotificationPusher\Model;

use Sly\NotificationPusher\Collection\DeviceCollection,
    Sly\NotificationPusher\Adapter\AdapterInterface,
    Sly\NotificationPusher\Model\Device,
    Sly\NotificationPusher\Model\Message,
    Sly\NotificationPusher\Exception\AdapterException
;

/**
 * Push.
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Push extends BaseOptionedModel
{
    const STATUS_PENDING = 'pending';
    const STATUS_SENT    = 'sent';

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
     * @param \Sly\NotificationPusher\Adapter\AdapterInterface                                         $adapter Adapter
     * @param \Sly\NotificationPusher\Model\Device|\Sly\NotificationPusher\Collection\DeviceCollection $devices Device(s)
     * @param \Sly\NotificationPusher\Model\Message                                                    $message Message
     * @param array                                                                                    $options Options
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

        $this->adapter = $adapter;
        $this->devices = $devices;
        $this->message = $message;
        $this->options = $options;
        $this->status  = self::STATUS_PENDING;
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
     * isSend.
     * 
     * @return boolean
     */
    public function isSent()
    {
        return (bool) (self::STATUS_SENT === $this->status);
    }

    /**
     * Declare as sent.
     *
     * @return \Sly\NotificationPusher\Model\Push
     */
    public function sent()
    {
        $this->status   = self::STATUS_SENT;
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
    
        return $this;
    }

    /**
     * Add a device.
     * 
     * @param \Sly\NotificationPusher\Model\Device $device Device
     */
    public function addDevice(Device $device)
    {
        $this->devices->add($device);
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
