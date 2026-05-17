<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class WarehouseTransfer extends Model
{
    use HasFactory;

    protected $fillable = [
        'transfer_code',
        'from_warehouse',
        'to_warehouse',
        'transfer_date',
        'requested_by',
        'transferred_by',
        'total_items',
        'total_quantity',
        'status', // 'pending', 'in-transit', 'received', 'completed'
        'notes',
    ];

    protected $casts = [
        'transfer_date' => 'datetime',
    ];

    public function transferDetails()
    {
        return $this->hasMany(TransferDetail::class);
    }

    public function requestedByUser()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function transferredByUser()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
