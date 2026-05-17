<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class QRCodeScan extends Model
{
    use HasFactory;

    protected $fillable = [
        'scan_code',
        'qr_code',
        'product_code',
        'product_name',
        'batch_number',
        'serial_number',
        'scanned_by',
        'scan_date',
        'scan_location',
        'scan_type', // 'receiving', 'release', 'transfer', 'verification', 'tracking'
        'reference_code',
        'quantity',
        'status', // 'success', 'error', 'invalid', 'duplicate'
        'error_message',
    ];

    protected $casts = [
        'scan_date' => 'datetime',
    ];

    public function scannedByUser()
    {
        return $this->belongsTo(User::class, 'scanned_by');
    }
}
