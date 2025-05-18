<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RolesPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Define all system permissions
        $permissions = [
            // Assessment permissions
            'create-assessment',
            'read-assessment',
            'update-assessment',
            'delete-assessment',

            // Result permissions
            'create-result',
            'read-result',
            'update-result',
            'delete-result',
        ];

        // Map roles to their allowed permissions
        $rolesWithPermissions = [
            'foundation' => [
                'create-assessment',
                'read-assessment',
                'update-assessment',
                'delete-assessment',
            ],
            'participant' => [
                'create-result',
                'read-result',
            ],
        ];

        // Create all permissions
        foreach ($permissions as $permissionName) {
            Permission::firstOrCreate(['name' => $permissionName]);
        }

        // Create roles and assign their permissions
        foreach ($rolesWithPermissions as $roleName => $permissionList) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            $role->syncPermissions($permissionList);
        }
    }
}
