<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class SerialScanHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'serial_number_tracking_id',
        'scan_code',
        'scan_type', // 'receiving', 'release', 'transfer', 'tracking', 'verification'
        'scanned_by',
        'scan_date',
        'scan_location',
        'reference_code',
        'status', // 'success', 'error'
        'notes',
    ];

    protected $casts = [
        'scan_date' => 'datetime',
    ];

    public function serialNumberTracking()
    {
        return $this->belongsTo(SerialNumberTracking::class);
    }

    public function scannedByUser()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
