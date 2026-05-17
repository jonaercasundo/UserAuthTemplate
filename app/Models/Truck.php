<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Truck extends Model
{
    protected $fillable = [
        'truck_code',
        'registration_number',
        'make',
        'model',
        'capacity_kg',
        'volume_cubic_meters',
        'acquisition_date',
        'last_service_date',
        'next_service_date',
        'insurance_expiry',
        'status',
    ];

    protected $casts = [
        'acquisition_date' => 'datetime',
        'last_service_date' => 'datetime',
        'next_service_date' => 'datetime',
        'insurance_expiry' => 'datetime',
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class);
    }
}
