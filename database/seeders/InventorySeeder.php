<?php

namespace Database\Seeders;

use App\Models\Inventory;
use Illuminate\Database\Seeder;

class InventorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'product_code' => 'PROD-001',
                'product_name' => 'Electronic Component A',
                'quantity_on_hand' => 45,
                'quantity_reserved' => 10,
                'quantity_available' => 35,
                'minimum_stock_level' => 50,
                'reorder_quantity' => 100,
                'unit_price' => 25.50,
            ],
            [
                'product_code' => 'PROD-002',
                'product_name' => 'Hardware Kit B',
                'quantity_on_hand' => 120,
                'quantity_reserved' => 20,
                'quantity_available' => 100,
                'minimum_stock_level' => 50,
                'reorder_quantity' => 200,
                'unit_price' => 15.75,
            ],
            [
                'product_code' => 'PROD-003',
                'product_name' => 'Assembly Unit C',
                'quantity_on_hand' => 8,
                'quantity_reserved' => 5,
                'quantity_available' => 3,
                'minimum_stock_level' => 30,
                'reorder_quantity' => 75,
                'unit_price' => 85.00,
            ],
            [
                'product_code' => 'PROD-004',
                'product_name' => 'Cable Set D',
                'quantity_on_hand' => 0,
                'quantity_reserved' => 0,
                'quantity_available' => 0,
                'minimum_stock_level' => 40,
                'reorder_quantity' => 150,
                'unit_price' => 12.30,
            ],
            [
                'product_code' => 'PROD-005',
                'product_name' => 'Connector E',
                'quantity_on_hand' => 250,
                'quantity_reserved' => 50,
                'quantity_available' => 200,
                'minimum_stock_level' => 75,
                'reorder_quantity' => 300,
                'unit_price' => 5.99,
            ],
            [
                'product_code' => 'PROD-006',
                'product_name' => 'Power Supply F',
                'quantity_on_hand' => 22,
                'quantity_reserved' => 5,
                'quantity_available' => 17,
                'minimum_stock_level' => 40,
                'reorder_quantity' => 80,
                'unit_price' => 55.00,
            ],
        ];

        foreach ($items as $item) {
            Inventory::create($item);
        }
    }
}
