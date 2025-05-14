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
        $permissions = [
            'view ClientG',
            'create ClientG',
            'edit ClientG',
            'view Software',
            'create Software',
            'edit Software',
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $client = Role::firstOrCreate(['name' => 'client']);
        $technical = Role::firstOrCreate(['name' => 'technical']);
        $admin = Role::firstOrCreate(['name' => 'admin']);

        $client->syncPermissions([
            'view ClientG',
            'view Software',
        ]);

        $technical->syncPermissions([
            'view ClientG', 'create ClientG', 'edit ClientG',
            'view Software', 'create Software', 'edit Software',
        ]);

        $admin->syncPermissions($technical->permissions);
    }
}
