<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class InventoryAlert extends Model
{
    use HasFactory;

    protected $fillable = [
        'alert_code',
        'product_code',
        'product_name',
        'alert_type', // 'low-stock', 'out-of-stock', 'overstock'
        'current_quantity',
        'threshold_quantity',
        'alert_date',
        'status', // 'active', 'acknowledged', 'resolved'
        'notes',
    ];

    protected $casts = [
        'alert_date' => 'datetime',
    ];

    // Scope for active alerts
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    // Scope for unacknowledged alerts
    public function scopeUnacknowledged($query)
    {
        return $query->where('status', 'active');
    }
}
