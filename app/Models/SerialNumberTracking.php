<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerialNumberTracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_code',
        'product_code',
        'product_name',
        'serial_number',
        'batch_number',
        'received_date',
        'status', // 'in-warehouse', 'released', 'transferred', 'damaged', 'lost'
        'current_location',
        'warehouse_location',
        'last_scanned_date',
        'last_scanned_location',
        'owner_user_id',
        'notes',
    ];

    protected $casts = [
        'received_date' => 'datetime',
        'last_scanned_date' => 'datetime',
    ];

    public function scanHistory()
    {
        return $this->hasMany(SerialScanHistory::class);
    }

    public function ownerUser()
    {
        return $this->belongsTo(User::class, 'owner_user_id');
    }
}
