<?php

namespace JobMetric\Sms\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JobMetric\Authio\Models\User;

/**
 * @property int $sms_gateway_id
 * @property int $user_id
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
 * @property SmsGateway $smsGateway
 * @property User $user
 */
class Sms extends Model
{
    use HasFactory;

    protected $fillable = [
        'sms_gateway_id',
        'user_id',
        'mobile_prefix',
        'mobile',
        'sender',
        'pattern',
        'inputs',
        'note',
        'note_type',
        'page',
        'price',
        'reference_id',
        'reference_status',
        'reference_trace',
        'status',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'sms_gateway_id' => 'int',
        'user_id' => 'int',
        'mobile_prefix' => 'string',
        'mobile' => 'string',
        'sender' => 'string',
        'pattern' => 'string',
        'inputs' => 'array',
        'note' => 'string',
        'note_type' => 'string',
        'page' => 'int',
        'price_per_page' => 'float',
        'price' => 'float',
        'reference_id' => 'string',
        'reference_status' => 'string',
        'reference_trace' => 'string',
        'status' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTable()
    {
        return config('sms.tables.sms', parent::getTable());
    }

    public function smsGateway(): BelongsTo
    {
        return $this->belongsTo(SmsGateway::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
