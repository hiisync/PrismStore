<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $permissions = [
            'see admin dashboard',
            'see users',
            'edit users',
            'delete users',
            'see roles',
            'create roles',
            'edit roles',
            'delete roles',
            'see products in admin panel',
            'create products',
            'edit products',
            'delete products',
            'see categories in admin panel',
            'create categories',
            'edit categories',
            'delete categories',
            'see pages in admin panel',
            'create pages',
            'edit pages',
            'delete pages',
            'see navigations in admin panel',
            'create navigations',
            'edit navigations',
            'delete navigations',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        Role::create(['name' => 'user']);

        $rolePermissions = [
            'owner' => [
                'see admin dashboard',
                'see users',
                'edit users',
                'delete users',
                'see roles',
                'create roles',
                'edit roles',
                'delete roles',
                'see products in admin panel',
                'create products',
                'edit products',
                'delete products',
                'see categories in admin panel',
                'create categories',
                'edit categories',
                'delete categories',
            ],
        ];

        foreach ($rolePermissions as $roleName => $permissions) {
            $role = Role::create(['name' => $roleName]);
            foreach ($permissions as $permission) {
                $role->givePermissionTo($permission);
            }
        }

        $user = User::find(1);
        $user->assignRole('owner');
    }
}
