<?php

namespace Database\Seeders;

use App\Models\BarcodeScan;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class BarcodeScanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            ['code' => 'PROD-001', 'name' => 'Electronic Component A'],
            ['code' => 'PROD-002', 'name' => 'Hardware Kit B'],
            ['code' => 'PROD-003', 'name' => 'Assembly Unit C'],
        ];

        foreach ($products as $index => $product) {
            BarcodeScan::create([
                'scan_code' => 'BCS-' . date('Ymd') . '-' . str_pad($index + 1, 3, '0', STR_PAD_LEFT),
                'barcode' => 'BC-' . str_pad($product['code'], 10),
                'product_code' => $product['code'],
                'product_name' => $product['name'],
                'scanned_by' => 2,
                'scan_date' => Carbon::now()->subHours(random_int(1, 24)),
                'scan_location' => 'Receiving Gate 1',
                'scan_type' => 'receiving',
                'reference_code' => 'RCV-' . date('Ymd') . '-001',
                'quantity' => random_int(1, 10),
                'status' => 'success',
            ]);
        }
    }
}
