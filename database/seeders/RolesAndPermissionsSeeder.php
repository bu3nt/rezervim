<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesAndPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Reset cached roles and permissions
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // create permissions
        Permission::create(['name' => 'edit roles', 'guard_name' => 'web']);

        // create roles and assign created permissions
        $role = Role::create(['name' => 'super-admin', 'guard_name' => 'web']);
        $role->givePermissionTo(Permission::all());

        $role = Role::create(['name' => 'admin', 'guard_name' => 'web']);
        $role->givePermissionTo('edit roles');

        $role = Role::create(['name' => 'member', 'guard_name' => 'web']);
    }
}
