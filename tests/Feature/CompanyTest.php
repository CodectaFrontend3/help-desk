<?php

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("Company");});

it('list all companies', function () {
    Company::factory()->count(3)->create();

    $response = $this->getJson(route('company.index'));

    $response->assertOk()
             ->assertJsonCount(3);
});

test('create a company', function () {
    $data = [
        'client_name' => 'ACME S.A.',
        'ruc' => '12345678901',
        'address' => 'Av. Siempre Viva 742',
        'phone' => '987654321',
        'email' => 'acme@correo.com',
    ];

    $response = $this->postJson(route('company.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('companies', $data);
});

test('show a specific company', function () {
    $company = Company::factory()->create();

    $response = $this->getJson(route('company.show', ['company' => $company->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $company->id,
                 'client_name' => $company->client_name,
             ]);
});

test('update a company', function () {
    $company = Company::factory()->create();

    $nuevosDatos = [
        'client_name' => 'Nueva Empresa',
        'ruc' => '22233344455',
        'address' => 'Calle Nueva 456',
        'phone' => '111222333',
        'email' => 'nueva@empresa.com',
    ];

    $response = $this->putJson(route('company.update', ['company' => $company->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('companies', $nuevosDatos);
});

test('delete a company', function () {
    $company = Company::factory()->create();

    $response = $this->deleteJson(route('company.destroy', ['company' => $company->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('companies', ['id' => $company->id]);
});

