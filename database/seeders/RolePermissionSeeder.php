<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create(['name' => 'superadmin']);
        Role::create(['name' => 'admin']);
        Role::create(['name' => 'user']);
        Permission::create(['name' => 'view-user']);
        Permission::create(['name' => 'create-user']);
        Permission::create(['name' => 'update-user']);
        Permission::create(['name' => 'delete-user']);

        $roleSuperadmin = Role::findByName('superadmin');
        $roleSuperadmin->givePermissionTo('view-user');
        $roleSuperadmin->givePermissionTo('create-user');
        $roleSuperadmin->givePermissionTo('update-user');
        $roleSuperadmin->givePermissionTo('delete-user');

        $roleAdmin = Role::findByName('admin');
        $roleAdmin->givePermissionTo('view-user');
        $roleAdmin->givePermissionTo('create-user');

        $roleUser = Role::findByName('user');
        $roleUser->givePermissionTo('view-user');
        $roleUser->givePermissionTo('create-user');
    }
}
