<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Department;

class DepartmentSeeder extends Seeder
{
    public function run(): void
    {
        $departments = [
            'Human Resources',
            'Finance & Accounting',
            'Information Technology',
            'Sales & Marketing',
            'Operations',
            'Customer Service',
            'Procurement',
            'Logistics',
        ];

        foreach ($departments as $dept) {
            Department::create([
                'name' => $dept
            ]);
        }
    }
}
