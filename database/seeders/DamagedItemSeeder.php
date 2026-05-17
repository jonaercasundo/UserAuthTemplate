<?php

namespace Database\Seeders;

use App\Models\DamagedItem;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DamagedItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $items = [
            [
                'report_code' => 'DMG-001',
                'product_code' => 'PROD-001',
                'product_name' => 'Electronic Component A',
                'quantity_damaged' => 3,
                'damage_type' => 'Physical Damage',
                'reported_by' => 2,
                'reported_date' => Carbon::now(),
                'description' => 'Items received with broken casing',
                'status' => 'reported',
                'notes' => 'Waiting for assessment',
            ],
            [
                'report_code' => 'DMG-002',
                'product_code' => 'PROD-003',
                'product_name' => 'Assembly Unit C',
                'quantity_damaged' => 1,
                'damage_type' => 'Water Damage',
                'reported_by' => 2,
                'reported_date' => Carbon::yesterday(),
                'description' => 'Water exposure during storage',
                'status' => 'under-review',
                'notes' => 'Under quality assessment',
            ],
            [
                'report_code' => 'DMG-003',
                'product_code' => 'PROD-005',
                'product_name' => 'Connector E',
                'quantity_damaged' => 5,
                'damage_type' => 'Defective',
                'reported_by' => 2,
                'reported_date' => Carbon::now()->subDays(2),
                'description' => 'Manufacturing defects detected',
                'status' => 'resolved',
                'notes' => 'Returned to supplier',
            ],
        ];

        foreach ($items as $item) {
            DamagedItem::create($item);
        }
    }
}
