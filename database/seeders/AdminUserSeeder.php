<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Illuminate\Support\Facades\Hash;

class AdminUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create Admin Role if not exists
        $adminRole = Role::firstOrCreate([
            'name' => 'Admin'
        ]);

        // Create Default Admin User
        $admin = User::firstOrCreate(
            ['email' => 'admin@company.com'],
            [
                'name' => 'ITAdmin123',
                'password' => Hash::make('@password123!'),
                'employee_id' => 'ADMIN001',
                'status' => 'Active',
            ]
        );

        // Assign Admin Role
        $admin->assignRole($adminRole);
    }
}
