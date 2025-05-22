<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('ejecuta correctamente el seeder y asigna los permisos esperados', function () {
    // Ejecutar el seeder
    $this->seed(\Database\Seeders\RolePermissionSeeder::class);

    // Verificar que los roles existen
    expect(Role::where('name', 'client')->exists())->toBeTrue();
    expect(Role::where('name', 'technical')->exists())->toBeTrue();
    expect(Role::where('name', 'admin')->exists())->toBeTrue();

    // Verificar que un permiso esperado existe
    expect(Permission::where('name', 'view ClientG')->exists())->toBeTrue();
    expect(Permission::where('name', 'edit Software')->exists())->toBeTrue();
    expect(Permission::where('name', 'view alvert')->exists())->toBeTrue();

    // Verificar los permisos de cada rol
    $clientPermissions = Role::where('name', 'client')->first()->permissions->pluck('name')->toArray();
    $technicalPermissions = Role::where('name', 'technical')->first()->permissions->pluck('name')->toArray();
    $adminPermissions = Role::where('name', 'admin')->first()->permissions->pluck('name')->toArray();

    // Cliente solo puede ver
    expect($clientPermissions)->toMatchArray([expectedPermissions(
            ['ClientG', 'Software'], 
            ['view'])
    ]);

    // Técnico puede ver, crear y además editar software
    expect($technicalPermissions)->toMatchArray([expectedPermissions(
        ['ClientG', 'Software'], 
        ['view', 'create'], 
        ['edit Software'])
    ]);

    // Admin tiene todos los permisos
    expect($adminPermissions)->toContain(...expectedPermissions(
    ['ClientG', 'Software'],
    ['view', 'create', 'edit', 'delete'],
    ['view alvert'])
    );
    function expectedPermissions(array $models, array $terms, array $extra = []): array
    {
        $permissions = [];

        foreach ($models as $model) {
            foreach ($terms as $term) {
                $permissions[] = "$term $model";
            }
        }

        return array_merge($permissions, $extra);
    }
});
