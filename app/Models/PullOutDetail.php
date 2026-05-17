<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class PullOutDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_pull_out_id',
        'product_code',
        'product_name',
        'quantity_pulled',
        'batch_number',
        'serial_number',
        'reason_detail',
        'notes',
    ];

    public function itemPullOut()
    {
        return $this->belongsTo(ItemPullOut::class);
    }
}
