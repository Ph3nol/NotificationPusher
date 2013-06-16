<?php

namespace Sly\NotificationPusher\Adapter;

/**
 * GCM adapter.
 *
 * @uses \Sly\NotificationPusher\Adapter\BaseAdapter
 * @uses \Sly\NotificationPusher\Adapter\AdapterInterface
 *
 * @author Cédric Dugat <cedric@dugat.me>
 */
class Gcm extends BaseAdapter implements AdapterInterface
{
    /**
     * {@inheritdoc}
     */    
    public function supports($token)
    {
        return (162 == strlen($token));
    }
}
