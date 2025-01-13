<?php

namespace JobMetric\Sms\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use JobMetric\Authio\Http\Resources\UserResource;
use JobMetric\Authio\Models\User;
use JobMetric\Sms\Models\SmsGateway;

/**
 * @property int $id
 * @property SmsGateway $smsGateway
 * @property User $user
 * @property string $mobile_prefix
 * @property string $mobile
 * @property string $sender
 * @property string $pattern
 * @property array $inputs
 * @property string $note
 * @property string $note_type
 * @property int $page
 * @property float $price
 * @property string $reference_id
 * @property string $reference_status
 * @property string $reference_trace
 * @property string $status
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property mixed smsable_resource
 */
class SmsResource extends JsonResource
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
            'sms_gateway' => $this->whenLoaded('smsGateway', function () {
                return SmsGatewayResource::make($this->smsGateway);
            }),
            'user' => $this->whenLoaded('user', function () {
                return UserResource::make($this->user);
            }),
            'smsable' => $this?->smsable_resource,
            'mobile_prefix' => $this->mobile_prefix,
            'mobile' => $this->mobile,
            'sender' => $this->sender,
            'pattern' => $this->pattern,
            'inputs' => $this->inputs,
            'note' => $this->note,
            'note_type' => $this->note_type,
            'page' => $this->page,
            'price' => $this->price,
            'reference_id' => $this->reference_id,
            'reference_status' => $this->reference_status,
            'reference_trace' => $this->reference_trace,
            'status' => $this->status,
            'status_trans' => trans('sms::base.sms_status.' . $this->status),
            'created_at' => Carbon::make($this->created_at)->toDateTimeString(),
            'updated_at' => Carbon::make($this->updated_at)->toDateTimeString(),
        ];
    }
}
