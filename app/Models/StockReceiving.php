<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockReceiving extends Model
{
    use HasFactory;

    protected $fillable = [
        'receiving_code',
        'purchase_order_number',
        'supplier_id',
        'received_by',
        'receiving_date',
        'total_items',
        'total_quantity',
        'status', // 'pending', 'in-progress', 'completed'
        'notes',
    ];

    protected $casts = [
        'receiving_date' => 'datetime',
    ];

    public function receivingDetails()
    {
        return $this->hasMany(ReceivingDetail::class);
    }

    public function receivedByUser()
    {
        return $this->belongsTo(User::class, 'received_by');
    }
}
