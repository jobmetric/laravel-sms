<?php

namespace JobMetric\Sms\Exceptions;

use Exception;
use Throwable;

class SmsGatewayDefaultNotFoundException extends Exception
{
    public function __construct(int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('sms::base.exceptions.sms_gateway_default_not_found'), $code, $previous);
    }
}
