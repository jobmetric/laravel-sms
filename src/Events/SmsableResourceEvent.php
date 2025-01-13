<?php

namespace JobMetric\Sms\Events;

class SmsableResourceEvent
{
    /**
     * The smsable model instance.
     *
     * @var mixed
     */
    public mixed $smsable;

    /**
     * The resource to be filled by the listener.
     *
     * @var mixed|null
     */
    public mixed $resource;

    /**
     * Create a new event instance.
     *
     * @param mixed $smsable
     */
    public function __construct(mixed $smsable)
    {
        $this->smsable = $smsable;
        $this->resource = null;
    }
}
