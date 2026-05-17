<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ReturnItem extends Model
{
    protected $fillable = [
        'delivery_id',
        'return_code',
        'product_code',
        'product_name',
        'quantity_returned',
        'return_reason',
        'return_date',
        'return_condition',
        'processed_by',
        'status',
    ];

    protected $casts = [
        'return_date' => 'datetime',
    ];

    public function delivery(): BelongsTo
    {
        return $this->belongsTo(Delivery::class);
    }

    public function processedByUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'processed_by');
    }
}
