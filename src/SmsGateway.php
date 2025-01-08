<?php

namespace JobMetric\Sms;

use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use JobMetric\Sms\Events\SmsGatewayDeleteEvent;
use JobMetric\Sms\Events\SmsGatewayStoreEvent;
use JobMetric\Sms\Events\SmsGatewayUpdateEvent;
use JobMetric\Sms\Exceptions\SmsGatewayNotFoundException;
use JobMetric\Sms\Http\Requests\StoreSmsGatewayRequest;
use JobMetric\Sms\Http\Requests\UpdateSmsGatewayRequest;
use JobMetric\Sms\Http\Resources\SmsGatewayResource;
use JobMetric\Sms\Models\SmsGateway as SmsGatewayModel;
use Spatie\QueryBuilder\QueryBuilder;
use Throwable;

class SmsGateway
{
    /**
     * Get the specified sms gateway.
     *
     * @param array $filter
     *
     * @return QueryBuilder
     * @throws Throwable
     */
    public function query(array $filter = []): QueryBuilder
    {
        $fields = [
            'id',
            'name',
            'driver',
            'fields',
            'default',
            'created_at',
            'updated_at'
        ];

        return QueryBuilder::for(SmsGatewayModel::class)
            ->allowedFields($fields)
            ->allowedSorts($fields)
            ->allowedFilters($fields)
            ->defaultSort([
                'name'
            ])
            ->where($filter);
    }

    /**
     * Paginate the specified sms gateway.
     *
     * @param array $filter
     * @param int $page_limit
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function paginate(array $filter = [], int $page_limit = 15): AnonymousResourceCollection
    {
        return SmsGatewayResource::collection(
            $this->query($filter)->paginate($page_limit)
        );
    }

    /**
     * Get all sms gateway.
     *
     * @param array $filter
     *
     * @return AnonymousResourceCollection
     * @throws Throwable
     */
    public function all(array $filter = []): AnonymousResourceCollection
    {
        return SmsGatewayResource::collection(
            $this->query($filter)->get()
        );
    }

    /**
     * Store the specified sms gateway.
     *
     * @param array $data
     *
     * @return array
     * @throws Throwable
     */
    public function store(array $data): array
    {
        $validator = Validator::make($data, (new StoreSmsGatewayRequest)->rules());
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return [
                'ok' => false,
                'message' => trans('package-core::base.validation.errors'),
                'errors' => $errors,
                'status' => 422
            ];
        } else {
            $data = $validator->validated();
        }

        return DB::transaction(function () use ($data) {
            $smsGateway = new SmsGatewayModel;
            $smsGateway->name = $data['name'];
            $smsGateway->driver = $data['driver'];
            $smsGateway->fields = $data['fields'] ?? [];

            $smsGateway->save();

            event(new SmsGatewayStoreEvent($smsGateway, $data));

            return [
                'ok' => true,
                'message' => trans('sms::base.messages.sms_gateway.created'),
                'data' => SmsGatewayResource::make($smsGateway),
                'status' => 201
            ];
        });
    }

    /**
     * Update the specified sms gateway.
     *
     * @param int $sms_gateway_id
     * @param array $data
     *
     * @return array
     * @throws Throwable
     */
    public function update(int $sms_gateway_id, array $data): array
    {
        /**
         * @var SmsGatewayModel $sms_gateway
         */
        $sms_gateway = SmsGatewayModel::find($sms_gateway_id);

        if (!$sms_gateway) {
            throw new SmsGatewayNotFoundException($sms_gateway_id);
        }

        $validator = Validator::make($data, (new UpdateSmsGatewayRequest)->setSmsGatewayId($sms_gateway_id)->rules());
        if ($validator->fails()) {
            $errors = $validator->errors()->all();

            return [
                'ok' => false,
                'message' => trans('package-core::base.validation.errors'),
                'errors' => $errors,
                'status' => 422
            ];
        } else {
            $data = $validator->validated();
        }

        return DB::transaction(function () use ($data, $sms_gateway) {
            $sms_gateway->name = $data['name'];
            $sms_gateway->driver = $data['driver'];

            if (array_key_exists('fields', $data)) {
                $sms_gateway->fields = $data['fields'];
            }

            $sms_gateway->save();

            event(new SmsGatewayUpdateEvent($sms_gateway, $data));

            return [
                'ok' => true,
                'message' => trans('sms::base.messages.sms_gateway.updated'),
                'data' => SmsGatewayResource::make($sms_gateway),
                'status' => 200
            ];
        });
    }

    /**
     * Delete the specified sms gateway.
     *
     * @param int $sms_gateway_id
     *
     * @return array
     * @throws Throwable
     */
    public function delete(int $sms_gateway_id): array
    {
        /**
         * @var SmsGatewayModel $sms_gateway
         */
        $sms_gateway = SmsGatewayModel::find($sms_gateway_id);

        if (!$sms_gateway) {
            throw new SmsGatewayNotFoundException($sms_gateway_id);
        }

        $data = SmsGatewayResource::make($sms_gateway);

        $sms_gateway->delete();

        event(new SmsGatewayDeleteEvent($sms_gateway));

        return [
            'ok' => true,
            'message' => trans('sms::base.messages.sms_gateway.deleted'),
            'data' => $data,
            'status' => 200
        ];
    }
}
