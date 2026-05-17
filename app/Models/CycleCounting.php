<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CycleCounting extends Model
{
    use HasFactory;

    protected $fillable = [
        'count_code',
        'warehouse_id',
        'count_date',
        'counted_by',
        'total_items_counted',
        'discrepancies',
        'status', // 'pending', 'in-progress', 'completed', 'reconciled'
        'start_date',
        'end_date',
        'notes',
    ];

    protected $casts = [
        'count_date' => 'datetime',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function countDetails()
    {
        return $this->hasMany(CountDetail::class);
    }

    public function countedByUser()
    {
        return $this->belongsTo(User::class, 'counted_by');
    }
}
