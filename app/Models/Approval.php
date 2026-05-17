<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Approval extends Model
{
    use HasFactory;

    protected $fillable = [
        'approval_code',
        'approval_type', // 'inventory-transfer', 'purchase-order', 'adjustment'
        'requested_by',
        'requested_date',
        'approval_details',
        'status', // 'pending', 'approved', 'rejected'
        'approved_by',
        'approved_date',
        'rejection_reason',
    ];

    protected $casts = [
        'requested_date' => 'datetime',
        'approved_date' => 'datetime',
    ];

    public function requestedByUser()
    {
        return $this->belongsTo(User::class, 'requested_by');
    }

    public function approvedByUser()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Scope for pending approvals
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
