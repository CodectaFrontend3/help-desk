<?php

use App\Models\Hardware;
use App\Models\RegistroHardware;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('listas de todos los hardware', function () {
    Hardware::factory()->count(3)->create();

    $response = $this->getJson(route('hardware.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('un RegistroHardware puede tener muchos Hardware', function () {
    $registro = RegistroHardware::factory()->create();

    $hardware1 = Hardware::factory()->create(['id_RH' => $registro->id]);
    $hardware2 = Hardware::factory()->create(['id_RH' => $registro->id]);

    $registro->load('hardware');

    $this->assertCount(2, $registro->hardware);
    $this->assertTrue($registro->hardware->contains($hardware1));
    $this->assertTrue($registro->hardware->contains($hardware2));
});

it('crear un nuevo hardware', function () {
    $registro = RegistroHardware::factory()->create();

    $data = Hardware::factory()->make([
        'id_RH' => $registro->id,
    ])->toArray();

    $response = $this->postJson(route('hardware.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['num_serie' => $data['num_serie']]);

    $this->assertDatabaseHas('hardware', ['num_serie' => $data['num_serie']]);
});

it('mostrar un hardware específico', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->getJson(route('hardware.show',['hardware'=>$hardware->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $hardware->id]);
});

it('actualizar un hardware', function () {
    $hardware = Hardware::factory()->create();

    $nuevoProveedor = 'Proveedor Actualizado S.A.';
    $response = $this->putJson(route('hardware.update',['hardware'=>$hardware->id]), [
        ...$hardware->toArray(),
        'proveedor' => $nuevoProveedor,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('hardware', ['proveedor' => $nuevoProveedor]);
});

it('eliminar un hardware', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->deleteJson(route('hardware.destroy',['hardware'=>$hardware->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('hardware', ['id' => $hardware->id]);
});
