<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Inventory extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_code',
        'product_name',
        'quantity_on_hand',
        'quantity_reserved',
        'quantity_available',
        'minimum_stock_level',
        'reorder_quantity',
        'unit_price',
        'last_updated',
    ];

    protected $casts = [
        'last_updated' => 'datetime',
        'unit_price' => 'decimal:2',
    ];

    // Check if stock is low
    public function isLowStock(): bool
    {
        return $this->quantity_available <= $this->minimum_stock_level;
    }

    // Get stock status
    public function getStockStatus(): string
    {
        if ($this->quantity_available <= 0) {
            return 'out-of-stock';
        } elseif ($this->isLowStock()) {
            return 'low-stock';
        }
        return 'in-stock';
    }
}
