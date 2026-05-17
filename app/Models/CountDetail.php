<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CountDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'cycle_counting_id',
        'product_code',
        'product_name',
        'system_quantity',
        'counted_quantity',
        'variance',
        'variance_percentage',
        'batch_number',
        'status', // 'pending', 'counted', 'verified', 'discrepancy'
        'notes',
    ];

    public function cycleCounting()
    {
        return $this->belongsTo(CycleCounting::class);
    }
}
