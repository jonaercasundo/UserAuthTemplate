<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Position;

class PositionSeeder extends Seeder
{
    public function run(): void
    {
        $positions = [
            'CEO',
            'General Manager',
            'HR Manager',
            'HR Officer',
            'Finance Manager',
            'Accountant',
            'IT Manager',
            'Software Developer',
            'System Administrator',
            'Sales Manager',
            'Sales Executive',
            'Marketing Officer',
            'Operations Manager',
            'Warehouse Staff',
            'Customer Support',
            'Procurement Officer',
            'Logistics Coordinator',
        ];

        foreach ($positions as $position) {
            Position::create([
                'name' => $position
            ]);
        }
    }
}
