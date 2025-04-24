<?php

use App\Models\RegistroHardware;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('listar de los registros de hardware', function () {
    RegistroHardware::factory()->count(3)->create();

    $response = $this->getJson(route('registroHardware.index'));

    $response->assertOk()
            ->assertJsonCount(3);
});


it('crear un nuevo registro de hardware', function () {
    $data = RegistroHardware::factory()->make()->toArray();

    $response = $this->postJson(route('registroHardware.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['serie' => $data['serie']]);
    $this->assertDatabaseHas('registro_hardware', ['serie' => $data['serie']]);
});

it('mostrar un registro de hardware específico', function () {
    $registro = RegistroHardware::factory()->create();

    $response = $this->getJson(route('registroHardware.show',['registroHardware'=>$registro->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $registro->id]);
});

it('actualizar un registro de hardware', function () {
    $registro = RegistroHardware::factory()->create();

    $nuevoProveedor = 'Proveedor S.A.C.';
    $response = $this->putJson(route('registroHardware.update',['registroHardware'=>$registro->id]), [
        ...$registro->toArray(),
        'proveedor' => $nuevoProveedor,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('registro_hardware', ['proveedor' => $nuevoProveedor]);
});

it('eliminar un registro de hardware', function () {
    $registro = RegistroHardware::factory()->create();

    $response = $this->deleteJson(route('registroHardware.destroy',['registroHardware'=>$registro->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('registro_hardware', ['id' => $registro->id]);
});
