<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TransferDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'warehouse_transfer_id',
        'product_code',
        'product_name',
        'quantity_to_transfer',
        'quantity_transferred',
        'batch_number',
        'status',
        'notes',
    ];

    public function warehouseTransfer()
    {
        return $this->belongsTo(WarehouseTransfer::class);
    }
}
