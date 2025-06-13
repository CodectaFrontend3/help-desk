<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rol = Role::firstOrCreate(['name' => 'admin']);

        $permission = Permission::all();
        $rol->syncPermissions($permission);

        $user = User::factory()->create([
            'name' => 'Mario',
            'email' => 'mario@gmail.com',
            'password' => Hash::make('12345678'),
        ]);
        $user->assignRole('admin'); 
    }
}
