<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_code',
        'product_code',
        'product_name',
        'batch_number',
        'manufacture_date',
        'expiry_date',
        'quantity_received',
        'quantity_available',
        'quantity_used',
        'received_from',
        'warehouse_location',
        'status', // 'active', 'expired', 'exhausted', 'recalled'
        'notes',
    ];

    protected $casts = [
        'manufacture_date' => 'datetime',
        'expiry_date' => 'datetime',
    ];

    public function trackingHistory()
    {
        return $this->hasMany(BatchTrackingHistory::class);
    }
}
