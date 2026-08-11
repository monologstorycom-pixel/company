<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        // Create permissions
        $permissions = [
            // Product permissions
            'view products',
            'create products',
            'edit products',
            'delete products',

            // Article permissions
            'view articles',
            'create articles',
            'edit articles',
            'delete articles',

            // Page permissions
            'view pages',
            'create pages',
            'edit pages',
            'delete pages',

            // Contact permissions
            'view contacts',
            'edit contacts',
            'delete contacts',

            // Chatbot permissions
            'view chatbot',
            'create chatbot',
            'edit chatbot',
            'delete chatbot',

            // User permissions
            'view users',
            'create users',
            'edit users',
            'delete users',

            // Role permissions
            'view roles',
            'create roles',
            'edit roles',
            'delete roles',

            // Permission permissions (implicitly handled by role permissions)

            // Settings permissions
            'view settings',
            'edit settings',

            // Analytics permissions
            'view analytics',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Create roles and assign permissions
        $superAdmin = Role::firstOrCreate(['name' => 'Super Admin']);
        $superAdmin->givePermissionTo(Permission::all());

        $admin = Role::firstOrCreate(['name' => 'Admin']);
        $admin->givePermissionTo([
            'view products', 'create products', 'edit products', 'delete products',
            'view articles', 'create articles', 'edit articles', 'delete articles',
            'view pages', 'create pages', 'edit pages', 'delete pages',
            'view contacts', 'edit contacts', 'delete contacts',
            'view chatbot', 'create chatbot', 'edit chatbot', 'delete chatbot',
            'view analytics',
        ]);

        $marketing = Role::firstOrCreate(['name' => 'Marketing']);
        $marketing->givePermissionTo([
            'view articles', 'create articles', 'edit articles', 'delete articles',
            'view chatbot', // read-only access to chatbot conversation logs
            'view analytics', // content performance analytics
        ]);
    }
}
