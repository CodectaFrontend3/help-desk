<?php

use App\Models\Software;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todos los software', function () {
    Software::factory()->count(3)->create();

    $response = $this->getJson(route('software.index'));

    $response->assertOk()
    ->assertJsonCount(3);
});

it('crear un nuevo software', function () {
    $data = Software::factory()->make()->toArray();

    $response = $this->postJson(route('software.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['nombre' => $data['nombre']]);

    $this->assertDatabaseHas('software', ['nombre' => $data['nombre']]);
});

it('mostrar un software específico', function () {
    $software = Software::factory()->create();

    $response = $this->getJson(route('software.show', ['software' => $software->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $software->id]);
});

it('actualizar un software', function () {
    $software = Software::factory()->create();

    $nuevoNombre = 'Antivirus Pro 2025';
    $response = $this->putJson(route('software.update', ['software' => $software->id]), [
        ...$software->toArray(),
        'nombre' => $nuevoNombre,
    ]);

    $response->assertNoContent();
    $this->assertDatabaseHas('software', ['nombre' => $nuevoNombre]);
});

it('eliminar un software', function () {
    $software = Software::factory()->create();

    $response = $this->deleteJson(route('software.destroy', ['software' => $software->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('software', ['id' => $software->id]);
});
