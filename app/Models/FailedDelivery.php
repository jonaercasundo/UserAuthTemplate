<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FailedDelivery extends Model
{
    protected $fillable = [
        'delivery_id',
        'failure_code',
        'failure_reason',
        'failure_date',
        'retry_date',
        'retry_count',
        'driver_notes',
        'reported_by',
        'status',
    ];

    protected $casts = [
        'failure_date' => 'datetime',
        'retry_date' => 'datetime',
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function reportedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'reported_by');
    }
}
