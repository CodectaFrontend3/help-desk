<?php

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

function AssignPermissions(array $models, array $terms, array $extra = []): array
    {
        $permissions = [];

        foreach ($models as $model) {
            foreach ($terms as $term) {
                $permissions[] = "$term $model";
            }
        }

        if (!empty($extra)) {
            $permissions = array_merge($permissions, $extra);
        }

        return $permissions;
    }

it('ejecuta correctamente la asigna los permisos esperados', function () {
    $this->seed(\Database\Seeders\RolePermissionSeeder::class);

    expect(Role::where('name', 'client')->exists())->toBeTrue();
    expect(Role::where('name', 'technical')->exists())->toBeTrue();
    expect(Role::where('name', 'admin')->exists())->toBeTrue();

    $clientPermissions = Role::where('name', 'client')->first()->permissions->pluck('name')->toArray();
    $technicalPermissions = Role::where('name', 'technical')->first()->permissions->pluck('name')->toArray();
    $adminPermissions = Role::where('name', 'admin')->first()->permissions->pluck('name')->toArray();

    expect($clientPermissions)->toContain(
        ...AssignPermissions(['ClientG'], ['view'])
    );

    expect($technicalPermissions)->toContain(
        ...AssignPermissions(['ClientG'],  ['view', 'create'])
    );

    expect($adminPermissions)->toContain(
        ...AssignPermissions(['ClientG'],['view', 'create', 'edit', 'delete'],
    ));
});
