<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionSeeder extends Seeder
{
    public function run(): void
    {
        // Permissions
        $permissions = [
            'Employee Record',
            'Manage Users',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission,
                'guard_name' => 'web',
            ]);
        }

        // Roles
        $roles = [
            'Admin',
            'HR',
            'Finance',
            'Sales',
            'Operations',
            'Customer Service',
            'Procurement',
            'Logistics',
            'Staff',
        ];

        foreach ($roles as $roleName) {
            Role::firstOrCreate([
                'name' => $roleName,
                'guard_name' => 'web',
            ]);
        }

        // Assign permissions
        Role::findByName('Admin', 'web')
            ->givePermissionTo(Permission::all());

        Role::findByName('HR', 'web')
            ->givePermissionTo(['Employee Record']);
    }
}