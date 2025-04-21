<?php

use App\Models\Hardware;
use App\Models\RegistroHardware;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('listas de todos los hardware', function () {
    Hardware::factory()->count(3)->create();

    $response = $this->getJson('/api/hardware');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('crear un nuevo hardware', function () {
    $registro = RegistroHardware::factory()->create();

    $data = Hardware::factory()->make([
        'id_RH' => $registro->id,
    ])->toArray();

    $response = $this->postJson('/api/hardware', $data);

    $response->assertCreated();
    $response->assertJsonFragment(['num_serie' => $data['num_serie']]);

    $this->assertDatabaseHas('hardware', ['num_serie' => $data['num_serie']]);
});

it('mostrar un hardware específico', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->getJson("/api/hardware/{$hardware->id}");

    $response->assertOk()
             ->assertJsonFragment(['id' => $hardware->id]);
});

it('actualizar un hardware', function () {
    $hardware = Hardware::factory()->create();

    $nuevoProveedor = 'Proveedor Actualizado S.A.';
    $response = $this->putJson("/api/hardware/{$hardware->id}", [
        ...$hardware->toArray(),
        'proveedor' => $nuevoProveedor,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('hardware', ['proveedor' => $nuevoProveedor]);
});

it('eliminar un hardware', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->deleteJson("/api/hardware/{$hardware->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('hardware', ['id' => $hardware->id]);
});
