<?php

namespace Database\Seeders;

use App\Models\SerialNumberTracking;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class SerialNumberTrackingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 5; $i++) {
            SerialNumberTracking::create([
                'serial_code' => 'SER-' . date('Ymd') . '-' . str_pad($i, 3, '0', STR_PAD_LEFT),
                'product_code' => 'PROD-' . str_pad(($i % 3) + 1, 3, '0', STR_PAD_LEFT),
                'product_name' => 'Product ' . chr(64 + (($i % 3) + 1)),
                'serial_number' => 'SN-' . str_pad($i * 1000, 6, '0', STR_PAD_LEFT),
                'batch_number' => 'BATCH-' . str_pad(($i % 3) + 1, 3, '0', STR_PAD_LEFT),
                'received_date' => Carbon::now()->subDays(random_int(1, 30)),
                'status' => $i <= 3 ? 'in-warehouse' : 'released',
                'current_location' => 'Warehouse A',
                'warehouse_location' => 'A-' . str_pad($i, 2, '0', STR_PAD_LEFT) . '-01',
                'last_scanned_date' => Carbon::now()->subHours(random_int(1, 48)),
                'last_scanned_location' => 'Gate 1',
                'owner_user_id' => $i <= 3 ? null : 2,
            ]);
        }
    }
}
