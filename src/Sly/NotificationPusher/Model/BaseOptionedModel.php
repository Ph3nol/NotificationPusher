<?php

namespace Sly\NotificationPusher\Model;

/**
 * BaseOptionedModel.
 * 
 * @author Cédric Dugat <cedric@dugat.me>
 */
abstract class BaseOptionedModel
{
    /**
     * @var array
     */
    protected $options = array();

    /**
     * Get options.
     *
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }

    /**
     * Has option.
     * 
     * @param string $key Key
     * 
     * @return boolean
     */
    public function hasOption($key)
    {
        return array_key_exists($key, $this->options);
    }

    /**
     * Get option.
     * 
     * @param string $key     Key
     * @param mixed  $default Default
     * 
     * @return mixed
     */
    public function getOption($key, $default = null)
    {
        return $this->hasOption($key) ? $this->options[$key] : $default;
    }

    /**
     * Set options.
     *
     * @param array $options Options
     *
     * @return \Sly\NotificationPusher\Model\BaseOptionedModel
     */
    public function setOptions($options)
    {
        $this->options = $options;

        return $this;
    }

    /**
     * Set option.
     *
     * @param string $key   Key
     * @param mixed  $value Value
     *
     * @return mixed
     */
    public function setOption($key, $value)
    {
        $this->options[$key] = $value;

        return $value;
    }
}
