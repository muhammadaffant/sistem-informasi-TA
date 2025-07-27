<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Daftar permission
        $permissions = [
            'view-dashboard',
            'manage-users',
            'manage-products',
            'manage-orders',
            'view-reports',
        ];

        // Buat permissions
        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Buat roles
        $adminRole = Role::firstOrCreate(['name' => 'admin']);
        $userRole = Role::firstOrCreate(['name' => 'user']);
        $ownerRole = Role::firstOrCreate(['name' => 'owner']);

        // Assign permissions ke role Admin
        $adminRole->syncPermissions($permissions);

        // Assign permissions tertentu ke role User
        $userRole->syncPermissions(['view-dashboard']);

        // Assign permissions tertentu ke role Owner
        $ownerRole->syncPermissions(['view-dashboard', 'view-reports']);

        $this->command->info('Roles and permissions seeded successfully!');
    }
}
