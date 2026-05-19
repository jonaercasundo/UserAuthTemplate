<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Supplier;

class ReceivingDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'stock_receiving_id',
        'product_code',
        'product_name',
        'supplier_id',
        'quantity_ordered',
        'quantity_received',
        'batch_number',
        'expiry_date',
        'unit_price',
        'status', // 'pending', 'received', 'discrepancy'
        'notes',
    ];

    protected $casts = [
        'expiry_date' => 'datetime',
        'unit_price' => 'decimal:2',
    ];

    public function stockReceiving()
    {
        return $this->belongsTo(StockReceiving::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
