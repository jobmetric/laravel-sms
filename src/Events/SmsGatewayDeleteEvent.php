<?php

namespace JobMetric\Sms\Events;

use JobMetric\Sms\Models\SmsGateway;

class SmsGatewayDeleteEvent
{
    /**
     * Create a new event instance.
     */
    public function __construct(
        public readonly SmsGateway $smsGateway
    )
    {
    }
}
