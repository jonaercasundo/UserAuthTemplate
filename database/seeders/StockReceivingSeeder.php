<?php

namespace Database\Seeders;

use App\Models\StockReceiving;
use App\Models\ReceivingDetail;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class StockReceivingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $receiving = StockReceiving::create([
            'receiving_code' => 'RCV-' . date('Ymd') . '-001',
            'purchase_order_number' => 'PO-2026-001',
            'supplier_id' => 'SUP-001',
            'received_by' => 2,
            'receiving_date' => Carbon::now(),
            'total_items' => 2,
            'total_quantity' => 100,
            'status' => 'completed',
        ]);

        ReceivingDetail::create([
            'stock_receiving_id' => $receiving->id,
            'product_code' => 'PROD-001',
            'product_name' => 'Electronic Component A',
            'quantity_ordered' => 50,
            'quantity_received' => 50,
            'batch_number' => 'BATCH-001',
            'expiry_date' => Carbon::now()->addMonths(6),
            'unit_price' => 25.50,
            'status' => 'received',
        ]);

        ReceivingDetail::create([
            'stock_receiving_id' => $receiving->id,
            'product_code' => 'PROD-002',
            'product_name' => 'Hardware Kit B',
            'quantity_ordered' => 50,
            'quantity_received' => 50,
            'batch_number' => 'BATCH-002',
            'expiry_date' => Carbon::now()->addMonths(8),
            'unit_price' => 15.75,
            'status' => 'received',
        ]);
    }
}
