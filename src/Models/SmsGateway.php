<?php

namespace JobMetric\Sms\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property string $name
 * @property string $driver
 * @property array $fields
 * @property array $options
 * @property array $pricing
 * @property bool $default
 */
class SmsGateway extends Model
{
    use HasFactory,
        SoftDeletes;

    protected $fillable = [
        'name',
        'driver',
        'fields',
        'options',
        'pricing',
        'default',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'name' => 'string',
        'driver' => 'string',
        'fields' => 'array',
        'options' => 'array',
        'pricing' => 'array',
        'default' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function getTable()
    {
        return config('sms.tables.sms_gateway', parent::getTable());
    }
}
