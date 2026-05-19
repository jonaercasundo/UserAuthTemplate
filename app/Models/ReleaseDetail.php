<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;

class ReleaseDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_release_id',
        'product_code',
        'product_name',
        'supplier_id',
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

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
