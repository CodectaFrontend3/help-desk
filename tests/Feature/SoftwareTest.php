<?php

use App\Models\Software;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('puede listar todos los software', function () {
    Software::factory()->count(3)->create();

    $response = $this->getJson('/api/software');

    $response->assertOk()
             ->assertJsonCount(3);
});

it('puede crear un nuevo software', function () {
    $data = Software::factory()->make()->toArray();

    $response = $this->postJson('/api/software', $data);

    $response->assertCreated()
             ->assertJsonFragment(['nombre' => $data['nombre']]);

    $this->assertDatabaseHas('software', ['nombre' => $data['nombre']]);
});

it('puede mostrar un software específico', function () {
    $software = Software::factory()->create();

    $response = $this->getJson("/api/software/{$software->id}");

    $response->assertOk()
             ->assertJsonFragment(['id' => $software->id]);
});

it('puede actualizar un software', function () {
    $software = Software::factory()->create();

    $nuevoProveedor = 'Proveedor Modificado';
    $data = [...$software->toArray(), 'proveedor' => $nuevoProveedor];

    $response = $this->putJson("/api/software/{$software->id}", $data);

    $response->assertNoContent();
    $this->assertDatabaseHas('software', ['proveedor' => $nuevoProveedor]);
});

it('puede eliminar un software', function () {
    $software = Software::factory()->create();

    $response = $this->deleteJson("/api/software/{$software->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('software', ['id' => $software->id]);
});
