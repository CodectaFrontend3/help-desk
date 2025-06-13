<?php

use App\Models\Area;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("Area");});

// Test: crear un área
it('create an area', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    $response = $this->postJson('/api/areas', [
        'company_id' => $company->id,
        'branch_id' => $branch->id,
        'area_name' => 'Área de Prueba',
        'contact' => 'Juan Pérez',
        'phone' => '987654321',
        'email' => 'juan@empresa.com',
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment([
                 'area_name' => 'Área de Prueba',
                 'contact' => 'Juan Pérez',
             ]);

    expect(Area::count())->toBe(1);
});

// Test: listar todas las áreas
it('list all areas with their information', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    Area::factory()->count(3)->create([
        'company_id' => $company->id,
        'branch_id' => $branch->id,
    ]);

    $response = $this->getJson('/api/areas');

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

// Test: ver un área específica
it('show an area with its information', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);
    $area = Area::factory()->create([
        'company_id' => $company->id,
        'branch_id' => $branch->id,
    ]);

    $response = $this->getJson("/api/areas/{$area->id}");

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'id' => $area->id,
                 'area_name' => $area->area_name,
             ]);
});

// Test: actualizar un área
it('update an area', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);

    $area = Area::factory()->create([
        'company_id' => $company->id,
        'branch_id' => $branch->id,
    ]);

    $response = $this->putJson("/api/areas/{$area->id}", [
        'company_id' => $company->id,
        'branch_id' => $branch->id,
        'area_name' => 'Área Actualizada',
        'contact' => 'Ana López',
        'phone' => '912345678',
        'email' => 'ana@empresa.com',
    ]);

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'area_name' => 'Área Actualizada',
                 'contact' => 'Ana López',
             ]);
});

// Test: eliminar un área
it('delete an area', function () {
    $company = Company::factory()->create();
    $branch = Branch::factory()->create(['company_id' => $company->id]);
    $area = Area::factory()->create([
        'company_id' => $company->id,
        'branch_id' => $branch->id,
    ]);

    $response = $this->deleteJson("/api/areas/{$area->id}");

    $response->assertNoContent();
    expect(Area::count())->toBe(0);
});