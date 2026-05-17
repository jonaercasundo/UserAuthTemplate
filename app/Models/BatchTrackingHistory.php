<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class BatchTrackingHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'batch_tracking_id',
        'action_type', // 'received', 'released', 'transferred', 'adjusted'
        'quantity_changed',
        'reference_code',
        'user_id',
        'action_date',
        'notes',
    ];

    protected $casts = [
        'action_date' => 'datetime',
    ];

    public function batchTracking()
    {
        return $this->belongsTo(BatchTracking::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
