<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockAdjustment extends Model
{
    use HasFactory;

    protected $fillable = [
        'adjustment_code',
        'adjustment_type', // 'increase', 'decrease'
        'product_code',
        'product_name',
        'quantity_before',
        'quantity_after',
        'adjustment_quantity',
        'reason',
        'adjusted_by',
        'adjustment_date',
        'status', // 'pending', 'approved', 'completed'
        'approved_by',
        'notes',
    ];

    protected $casts = [
        'adjustment_date' => 'datetime',
    ];

    public function adjustedByUser()
    {
        return $this->belongsTo(User::class, 'adjusted_by');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}
