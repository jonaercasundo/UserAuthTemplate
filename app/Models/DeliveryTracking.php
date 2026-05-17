<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DeliveryTracking extends Model
{
    protected $fillable = [
        'delivery_id',
        'tracking_code',
        'status',
        'latitude',
        'longitude',
        'location_description',
        'tracking_timestamp',
        'updated_by',
        'notes',
    ];

    protected $casts = [
        'tracking_timestamp' => 'datetime',
        'latitude' => 'decimal:8',
        'longitude' => 'decimal:8',
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function updatedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
