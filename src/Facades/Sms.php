<?php

namespace JobMetric\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JobMetric\Sms\Sms
 *
 * @method static array processText(string $text)
 */
class Sms extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \JobMetric\Sms\Sms::class;
    }
}
