<?php

namespace JobMetric\Sms\Events;

use JobMetric\Sms\Models\SmsGateway;

class SmsGatewayUpdateEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly SmsGateway $smsGateway,
        public readonly array      $data,
    )
    {
    }
}
