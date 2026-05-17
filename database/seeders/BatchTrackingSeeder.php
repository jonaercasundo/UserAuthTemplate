<?php

namespace Database\Seeders;

use App\Models\BatchTracking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BatchTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        BatchTracking::create([
            'batch_code' => 'BAT-' . date('Ymd') . '-001',
            'product_code' => 'PROD-001',
            'product_name' => 'Electronic Component A',
            'batch_number' => 'BATCH-001',
            'manufacture_date' => Carbon::now()->subMonths(2),
            'expiry_date' => Carbon::now()->addMonths(4),
            'quantity_received' => 50,
            'quantity_available' => 45,
            'quantity_used' => 5,
            'received_from' => 'Global Supplies Inc.',
            'warehouse_location' => 'A-01-01',
            'status' => 'active',
        ]);

        BatchTracking::create([
            'batch_code' => 'BAT-' . date('Ymd') . '-002',
            'product_code' => 'PROD-002',
            'product_name' => 'Hardware Kit B',
            'batch_number' => 'BATCH-002',
            'manufacture_date' => Carbon::now()->subMonths(3),
            'expiry_date' => Carbon::now()->addMonths(5),
            'quantity_received' => 75,
            'quantity_available' => 70,
            'quantity_used' => 5,
            'received_from' => 'Tech Components Ltd.',
            'warehouse_location' => 'A-02-01',
            'status' => 'active',
        ]);

        BatchTracking::create([
            'batch_code' => 'BAT-' . date('Ymd') . '-003',
            'product_code' => 'PROD-003',
            'product_name' => 'Assembly Unit C',
            'batch_number' => 'BATCH-003',
            'manufacture_date' => Carbon::now()->subMonths(8),
            'expiry_date' => Carbon::now()->subMonth(),
            'quantity_received' => 20,
            'quantity_available' => 0,
            'quantity_used' => 20,
            'received_from' => 'Industrial Supply Co.',
            'warehouse_location' => 'B-01-01',
            'status' => 'expired',
        ]);
    }
}
