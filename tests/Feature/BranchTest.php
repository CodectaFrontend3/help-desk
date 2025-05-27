<?php

use App\Models\Branch;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("Branch");});

// Test: listar todas las sucursales
it('list all the branches with their company', function () {
    $company = Company::factory()->create();
    Branch::factory()->count(3)->create(['company_id' => $company->id]);

    $response = $this->getJson('/api/branches');

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

// Test: crear una sucursal
it('create a branch', function () {
    $company = Company::factory()->create();

    $response = $this->postJson('/api/branches', [
        'company_id' => $company->id,
        'branch_name' => 'Sucursal Norte',
        'manager' => 'Luis Gómez',
        'phone' => '987654321',
        'email' => 'norte@empresa.com',
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment([
                 'branch_name' => 'Sucursal Norte',
                 'manager' => 'Luis Gómez',
             ]);

    expect(Branch::count())->toBe(1);
});

// Test: ver una sucursal específica
it('Show a branch with its company', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    $response = $this->getJson("/api/branches/{$branch->id}");

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'id' => $branch->id,
                 'company_id' => $company->id,
             ]);
});

// Test: actualizar una sucursal
it('update a branch', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    $response = $this->putJson("/api/branches/{$branch->id}", [
        'company_id' => $company->id,
        'branch_name' => 'Sucursal Actualizada',
        'manager' => 'Ana Torres',
        'phone' => '555123456',
        'email' => 'actualizada@empresa.com',
    ]);

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'branch_name' => 'Sucursal Actualizada',
                 'manager' => 'Ana Torres',
             ]);
});

// Test: eliminar una sucursal
it('delete a branch', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    $response = $this->deleteJson("/api/branches/{$branch->id}");

    $response->assertNoContent();
    expect(Branch::count())->toBe(0);
});
