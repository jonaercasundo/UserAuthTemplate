<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Driver extends Model
{
    protected $fillable = [
        'driver_code',
        'user_id',
        'first_name',
        'last_name',
        'email',
        'phone',
        'license_number',
        'license_expiry',
        'date_of_birth',
        'address',
        'status',
    ];

    protected $casts = [
        'license_expiry' => 'datetime',
        'date_of_birth' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->first_name} {$this->last_name}";
    }
}
