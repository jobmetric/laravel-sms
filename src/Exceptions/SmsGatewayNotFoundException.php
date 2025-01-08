<?php

namespace JobMetric\Sms\Exceptions;

use Exception;
use Throwable;

class SmsGatewayNotFoundException extends Exception
{
    public function __construct(int $number, int $code = 404, ?Throwable $previous = null)
    {
        parent::__construct(trans('sms::base.exceptions.sms_gateway_not_found', [
            'number' => $number,
        ]), $code, $previous);
    }
}
