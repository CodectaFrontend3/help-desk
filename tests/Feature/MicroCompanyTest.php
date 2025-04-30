<?php

use App\Models\MicroCompany;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list all micro companies', function () {
    MicroCompany::factory()->count(3)->create();

    $response = $this->getJson(route('micro_company.index'));

    $response->assertOk()
             ->assertJsonCount(3);
});

test('create a micro company', function () {
    $data = [
        'client_name' => 'ACME S.A.',
        'ruc' => '12345678901',
        'address' => 'Av. Siempre Viva 742',
        'phone' => '987654321',
        'email' => 'acme@correo.com',
    ];

    $response = $this->postJson(route('micro_company.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('micro_companies', $data);
});

test('show a specific micro company', function () {
    $company = MicroCompany::factory()->create();

    $response = $this->getJson(route('micro_company.show', ['micro_company' => $company->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $company->id,
                 'client_name' => $company->client_name,
             ]);
});

test('update a micro company', function () {
    $company = MicroCompany::factory()->create();

    $nuevosDatos = [
        'client_name' => 'Nueva Empresa',
        'ruc' => '22233344455',
        'address' => 'Calle Nueva 456',
        'phone' => '111222333',
        'email' => 'nueva@empresa.com',
    ];

    $response = $this->putJson(route('micro_company.update', ['micro_company' => $company->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('micro_companies', $nuevosDatos);
});

test('delete a micro company', function () {
    $company = MicroCompany::factory()->create();

    $response = $this->deleteJson(route('micro_company.destroy', ['micro_company' => $company->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('micro_companies', ['id' => $company->id]);
});
