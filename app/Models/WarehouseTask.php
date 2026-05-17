<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WarehouseTask extends Model
{
    //
    protected $fillable = [
        'task_code',
        'assigned_to',
        'item_name',
        'quantity',
        'status',
        'notes',
    ];
    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

}
