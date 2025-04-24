<?php

use App\Models\Empresa;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todas las empresas', function () {
    Empresa::factory()->count(3)->create();

    $response = $this->getJson(route('empresa.index'));

    $response->assertOk()
             ->assertJsonCount(3);
});

test('crear una empresa', function () {
    $data = [
        'nombre_cliente' => 'ACME S.A.',
        'ruc' => '12345678901',
        'direccion' => 'Av. Siempre Viva 742',
        'telefono' => '987654321',
        'correo' => 'acme@correo.com',
    ];

    $response = $this->postJson(route('empresa.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('empresa', $data);
});

test('mostrar una empresa específica', function () {
    $empresa = Empresa::factory()->create();

    $response = $this->getJson(route('empresa.show', ['empresa' => $empresa->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $empresa->id,
                 'nombre_cliente' => $empresa->nombre_cliente,
             ]);
});

test('actualizar una empresa', function () {
    $empresa = Empresa::factory()->create();

    $nuevosDatos = [
        'nombre_cliente' => 'Nueva Empresa',
        'ruc' => '22233344455',
        'direccion' => 'Calle Nueva 456',
        'telefono' => '111222333',
        'correo' => 'nueva@empresa.com',
    ];

    $response = $this->putJson(route('empresa.update', ['empresa' => $empresa->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('empresa', $nuevosDatos);
});

test('eliminar una empresa', function () {
    $empresa = Empresa::factory()->create();

    $response = $this->deleteJson(route('empresa.destroy', ['empresa' => $empresa->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('empresa', ['id' => $empresa->id]);
});