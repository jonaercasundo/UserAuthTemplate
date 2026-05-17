<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ItemPullOut extends Model
{
    use HasFactory;

    protected $fillable = [
        'pullout_code',
        'pullout_type', // 'stock-shortage', 'damaged-stock', 'expired', 'return'
        'warehouse_id',
        'pulled_out_by',
        'pullout_date',
        'total_quantity',
        'reason',
        'status', // 'pending', 'completed'
        'notes',
    ];

    protected $casts = [
        'pullout_date' => 'datetime',
    ];

    public function pulloutDetails()
    {
        return $this->hasMany(PullOutDetail::class);
    }

    public function pulledOutByUser()
    {
        return $this->belongsTo(User::class, 'pulled_out_by');
    }
}
