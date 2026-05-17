<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Delivery extends Model
{
    use HasFactory;

    protected $fillable = [
        'delivery_code',
        'type', // 'incoming' or 'outgoing'
        'supplier_or_customer',
        'scheduled_date',
        'actual_date',
        'items_count',
        'status', // 'pending', 'in-transit', 'delivered', 'delayed'
        'notes',
    ];

    protected $casts = [
        'scheduled_date' => 'datetime',
        'actual_date' => 'datetime',
    ];

    // Scope for incoming deliveries
    public function scopeIncoming($query)
    {
        return $query->where('type', 'incoming');
    }

    // Scope for outgoing deliveries
    public function scopeOutgoing($query)
    {
        return $query->where('type', 'outgoing');
    }

    // Scope for pending deliveries
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    // Check if delayed
    public function isDelayed(): bool
    {
        return $this->status === 'delayed' || ($this->scheduled_date && $this->scheduled_date->isPast() && $this->status !== 'delivered');
    }
}
