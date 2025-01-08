<?php

namespace JobMetric\Sms\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \JobMetric\Sms\SmsGateway
 *
 * @method static \Spatie\QueryBuilder\QueryBuilder query(array $filter = [])
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection paginate(array $filter = [], int $page_limit = 15)
 * @method static \Illuminate\Http\Resources\Json\AnonymousResourceCollection all(array $filter = [])
 * @method static array store(array $data)
 * @method static array update(int $sms_gateway_id, array $data)
 * @method static array delete(int $sms_gateway_id)
 */
class SmsGateway extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor(): string
    {
        return \JobMetric\Sms\SmsGateway::class;
    }
}
