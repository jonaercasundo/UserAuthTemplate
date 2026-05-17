<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class DamagedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'report_code',
        'product_code',
        'product_name',
        'quantity_damaged',
        'damage_type',
        'reported_by',
        'reported_date',
        'description',
        'status', // 'reported', 'under-review', 'resolved'
        'notes',
    ];

    protected $casts = [
        'reported_date' => 'datetime',
    ];

    public function reportedBy()
    {
        return $this->belongsTo(User::class, 'reported_by');
    }

    // Scope for pending reports
    public function scopePending($query)
    {
        return $query->whereIn('status', ['reported', 'under-review']);
    }
}
