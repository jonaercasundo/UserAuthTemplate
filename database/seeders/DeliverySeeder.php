<?php

namespace Database\Seeders;

use App\Models\Delivery;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DeliverySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $deliveries = [
            [
                'delivery_code' => 'DEL-IN-001',
                'type' => 'incoming',
                'supplier_or_customer' => 'Global Supplies Inc.',
                'scheduled_date' => Carbon::tomorrow(),
                'actual_date' => null,
                'items_count' => 50,
                'status' => 'pending',
                'notes' => 'Awaiting warehouse receiving',
            ],
            [
                'delivery_code' => 'DEL-IN-002',
                'type' => 'incoming',
                'supplier_or_customer' => 'Tech Components Ltd.',
                'scheduled_date' => Carbon::now()->addDays(2),
                'actual_date' => null,
                'items_count' => 75,
                'status' => 'in-transit',
                'notes' => 'In transit from warehouse',
            ],
            [
                'delivery_code' => 'DEL-OUT-001',
                'type' => 'outgoing',
                'supplier_or_customer' => 'Customer Order #1234',
                'scheduled_date' => Carbon::now()->addDay(),
                'actual_date' => null,
                'items_count' => 30,
                'status' => 'pending',
                'notes' => 'Ready for shipment',
            ],
            [
                'delivery_code' => 'DEL-OUT-002',
                'type' => 'outgoing',
                'supplier_or_customer' => 'Customer Order #1235',
                'scheduled_date' => Carbon::now()->subDay(),
                'actual_date' => null,
                'items_count' => 45,
                'status' => 'delayed',
                'notes' => 'Delayed due to inventory issue',
            ],
            [
                'delivery_code' => 'DEL-IN-003',
                'type' => 'incoming',
                'supplier_or_customer' => 'Industrial Supply Co.',
                'scheduled_date' => Carbon::yesterday(),
                'actual_date' => Carbon::yesterday(),
                'items_count' => 100,
                'status' => 'delivered',
                'notes' => 'Successfully delivered',
            ],
            [
                'delivery_code' => 'DEL-OUT-003',
                'type' => 'outgoing',
                'supplier_or_customer' => 'Customer Order #1236',
                'scheduled_date' => Carbon::now()->addDay(),
                'actual_date' => null,
                'items_count' => 20,
                'status' => 'in-transit',
                'notes' => 'Dispatched with courier',
            ],
        ];

        foreach ($deliveries as $delivery) {
            Delivery::create($delivery);
        }
    }
}
