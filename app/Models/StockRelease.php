<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class StockRelease extends Model
{
    use HasFactory;

    protected $fillable = [
        'release_code',
        'release_type', // 'customer-order', 'internal-use', 'return', 'disposal'
        'reference_number',
        'released_by',
        'release_date',
        'total_items',
        'total_quantity',
        'status', // 'pending', 'released', 'completed'
        'notes',
    ];

    protected $casts = [
        'release_date' => 'datetime',
    ];

    public function releaseDetails()
    {
        return $this->hasMany(ReleaseDetail::class);
    }

    public function releasedByUser()
    {
        return $this->belongsTo(User::class, 'released_by');
    }
}
