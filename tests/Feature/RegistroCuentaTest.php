<?php
use App\Models\RegistroCuenta;
use App\Models\ClienteG;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista de todas las cuentas registradas', function () {
    RegistroCuenta::factory()->count(3)->create();

    $response = $this->getJson('/api/registroCuenta');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('registrar una nueva cuenta', function () {
    $cliente = ClienteG::factory()->create();

    $data = [
        'id_clienteG' => $cliente->id,
        'correo' => 'prueba@gmail.com',
        'contraseña' => 'a12345678955'
    ];

    $response = $this->postJson('/api/registroCuenta', $data);

    $response->assertCreated();
    $this->assertDatabaseHas('registro_cuentas', $data);
});

it('mostrar una cuenta específica', function () {
    $registro = RegistroCuenta::factory()->create();

    $response = $this->getJson("/api/registroCuenta/{$registro->id}");

    $response->assertOk();
    $response->assertJson([
        'id' => $registro->id,
        'correo' => $registro->correo,
    ]);
});

it('actualizar una cuenta', function () {
    $registro = RegistroCuenta::factory()->create();
    $nuevoCliente = ClienteG::factory()->create();

    $data = [
        'id_clienteG' => $nuevoCliente->id,
        'correo' => 'nuevo@gmail.com',
        'contraseña' => 'a12345678955'
    ];

    $response = $this->putJson("/api/registroCuenta/{$registro->id}", $data);

    $response->assertNoContent();
    $this->assertDatabaseHas('registro_cuentas', array_merge(['id' => $registro->id], $data));
});

it('eliminar una cuenta', function () {
    $registro = RegistroCuenta::factory()->create();

    $response = $this->deleteJson("/api/registroCuenta/{$registro->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('registro_cuentas', ['id' => $registro->id]);
});
