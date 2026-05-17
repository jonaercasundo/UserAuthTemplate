<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DeliveryRoute extends Model
{
    protected $fillable = [
        'route_code',
        'route_name',
        'starting_point',
        'ending_point',
        'total_stops',
        'estimated_distance_km',
        'estimated_duration_hours',
        'description',
        'status',
    ];

    public function deliveries(): HasMany
    {
        return $this->hasMany(Delivery::class, 'route_id');
    }
}
