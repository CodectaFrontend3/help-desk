<?php

use App\Models\MicroEmpresa;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todas las microempresas', function () {
    MicroEmpresa::factory()->count(3)->create();

    $response = $this->getJson(route('microempresa.index'));

    $response->assertOk()
             ->assertJsonCount(3);
});

test('crear una microempresa', function () {
    $data = [
        'nombre_cliente' => 'Microempresa S.A.',
        'ruc' => '98765432101',
        'direccion' => 'Av. Micro 123',
        'telefono' => '998877665',
        'correo' => 'microempresa@correo.com',
    ];

    $response = $this->postJson(route('microempresa.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('micro_empresas', $data);
});

test('mostrar una microempresa específica', function () {
    $microempresa = MicroEmpresa::factory()->create();

    $response = $this->getJson(route('microempresa.show', ['microempresa' => $microempresa->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $microempresa->id,
                 'nombre_cliente' => $microempresa->nombre_cliente,
             ]);
});

test('actualizar una microempresa', function () {
    $microempresa = MicroEmpresa::factory()->create();

    $nuevosDatos = [
        'nombre_cliente' => 'Nueva Microempresa',
        'ruc' => '11223344556',
        'direccion' => 'Calle Nueva 789',
        'telefono' => '123456789',
        'correo' => 'nueva@microempresa.com',
    ];

    $response = $this->putJson(route('microempresa.update', ['microempresa' => $microempresa->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('micro_empresas', $nuevosDatos);
});

test('eliminar una microempresa', function () {
    $microempresa = MicroEmpresa::factory()->create();

    $response = $this->deleteJson(route('microempresa.destroy', ['microempresa' => $microempresa->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('micro_empresas', ['id' => $microempresa->id]);
});
