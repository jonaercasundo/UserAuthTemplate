<?php

namespace Database\Seeders;

use App\Models\InventoryAlert;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class InventoryAlertSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $alerts = [
            [
                'alert_code' => 'ALT-001',
                'product_code' => 'PROD-001',
                'product_name' => 'Electronic Component A',
                'alert_type' => 'low-stock',
                'current_quantity' => 35,
                'threshold_quantity' => 50,
                'alert_date' => Carbon::now(),
                'status' => 'active',
                'notes' => 'Stock level below minimum threshold',
            ],
            [
                'alert_code' => 'ALT-002',
                'product_code' => 'PROD-004',
                'product_name' => 'Cable Set D',
                'alert_type' => 'out-of-stock',
                'current_quantity' => 0,
                'threshold_quantity' => 40,
                'alert_date' => Carbon::now(),
                'status' => 'active',
                'notes' => 'Out of stock - urgent reorder required',
            ],
            [
                'alert_code' => 'ALT-003',
                'product_code' => 'PROD-003',
                'product_name' => 'Assembly Unit C',
                'alert_type' => 'low-stock',
                'current_quantity' => 3,
                'threshold_quantity' => 30,
                'alert_date' => Carbon::now(),
                'status' => 'active',
                'notes' => 'Critical stock level',
            ],
            [
                'alert_code' => 'ALT-004',
                'product_code' => 'PROD-006',
                'product_name' => 'Power Supply F',
                'alert_type' => 'low-stock',
                'current_quantity' => 17,
                'threshold_quantity' => 40,
                'alert_date' => Carbon::now()->subDay(),
                'status' => 'acknowledged',
                'notes' => 'Acknowledged by warehouse manager',
            ],
        ];

        foreach ($alerts as $alert) {
            InventoryAlert::create($alert);
        }
    }
}
