<?php

namespace Database\Seeders;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $orders = [
            [
                'order_code' => 'ORD-' . date('Ymd') . '-001',
                'order_date' => Carbon::now(),
                'total_items' => 25,
                'total_amount' => 2500.00,
                'status' => 'processing',
                'notes' => 'Standard order',
            ],
            [
                'order_code' => 'ORD-' . date('Ymd') . '-002',
                'order_date' => Carbon::now(),
                'total_items' => 15,
                'total_amount' => 1500.00,
                'status' => 'pending',
                'notes' => 'Urgent order',
            ],
            [
                'order_code' => 'ORD-' . date('Ymd') . '-003',
                'order_date' => Carbon::now(),
                'total_items' => 40,
                'total_amount' => 4200.00,
                'status' => 'completed',
                'notes' => 'Completed order',
            ],
            [
                'order_code' => 'ORD-' . date('Ymd') . '-004',
                'order_date' => Carbon::yesterday(),
                'total_items' => 30,
                'total_amount' => 3100.00,
                'status' => 'completed',
                'notes' => 'Previous day order',
            ],
            [
                'order_code' => 'ORD-' . date('Ymd') . '-005',
                'order_date' => Carbon::now(),
                'total_items' => 50,
                'total_amount' => 5000.00,
                'status' => 'processing',
                'notes' => 'Large bulk order',
            ],
        ];

        foreach ($orders as $order) {
            Order::create($order);
        }
    }
}
