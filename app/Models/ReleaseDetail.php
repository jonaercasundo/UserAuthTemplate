<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ReleaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_release_id',
        'product_code',
        'product_name',
        'quantity_to_release',
        'quantity_released',
        'batch_number',
        'serial_number',
        'status',
        'notes',
    ];

    public function stockRelease()
    {
        return $this->belongsTo(StockRelease::class);
    }
}
