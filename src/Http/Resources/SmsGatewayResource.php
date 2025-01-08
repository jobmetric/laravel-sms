<?php

namespace JobMetric\Sms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

/**
 * @property int $id
 * @property string $name
 * @property string $driver
 * @property array $fields
 * @property bool $default
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class SmsGatewayResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'driver' => $this->driver,
            'fields' => $this->fields,
            'default' => $this->default,
            'created_at' => Carbon::make($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::make($this->updated_at)->toDateTimeString(),
        ];
    }
}
