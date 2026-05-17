<?php

namespace Database\Seeders;

use App\Models\Approval;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class ApprovalSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $approvals = [
            [
                'approval_code' => 'APR-001',
                'approval_type' => 'inventory-transfer',
                'requested_by' => 2,
                'requested_date' => Carbon::now(),
                'approval_details' => json_encode([
                    'from_warehouse' => 'Main Warehouse',
                    'to_warehouse' => 'Branch Warehouse',
                    'items' => [
                        ['product_code' => 'PROD-001', 'quantity' => 25],
                        ['product_code' => 'PROD-002', 'quantity' => 50],
                    ]
                ]),
                'status' => 'pending',
                'approved_by' => null,
                'approved_date' => null,
                'rejection_reason' => null,
            ],
            [
                'approval_code' => 'APR-002',
                'approval_type' => 'purchase-order',
                'requested_by' => 2,
                'requested_date' => Carbon::yesterday(),
                'approval_details' => json_encode([
                    'supplier' => 'Global Supplies Inc.',
                    'items' => [
                        ['product_code' => 'PROD-004', 'quantity' => 150, 'unit_price' => 12.30],
                    ],
                    'total_cost' => 1845.00,
                ]),
                'status' => 'approved',
                'approved_by' => 1,
                'approved_date' => Carbon::yesterday(),
                'rejection_reason' => null,
            ],
            [
                'approval_code' => 'APR-003',
                'approval_type' => 'adjustment',
                'requested_by' => 2,
                'requested_date' => Carbon::now()->subDays(2),
                'approval_details' => json_encode([
                    'reason' => 'Inventory Count Discrepancy',
                    'items' => [
                        ['product_code' => 'PROD-001', 'current' => 35, 'adjusted' => 30],
                    ]
                ]),
                'status' => 'pending',
                'approved_by' => null,
                'approved_date' => null,
                'rejection_reason' => null,
            ],
        ];

        foreach ($approvals as $approval) {
            Approval::create($approval);
        }
    }
}
