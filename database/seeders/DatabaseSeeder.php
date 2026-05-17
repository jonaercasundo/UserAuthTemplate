<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        $this->call(AdminUserSeeder::class);
        $this->call([
            DepartmentSeeder::class,
            PositionSeeder::class,
        ]);
        User::factory()->create([
                'employee_id' => 'EMP-0001', // ADD THIS
                'name' => 'Test User',
                'email' => 'test@example.com',
                'status' => 'Active',
                'department_id' => 1,
                'position_id' => 1,

        ]);

        // Operations Dashboard Seeders
        $this->call([
            OrderSeeder::class,
            InventorySeeder::class,
            DeliverySeeder::class,
            DamagedItemSeeder::class,
            ApprovalSeeder::class,
            InventoryAlertSeeder::class,
        ]);

        // Warehouse Management Seeders
        $this->call([
            StockReceivingSeeder::class,
            BatchTrackingSeeder::class,
            SerialNumberTrackingSeeder::class,
            BarcodeScanSeeder::class,
        ]);
    }
}
