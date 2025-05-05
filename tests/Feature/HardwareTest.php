<?php

use App\Models\Hardware;
use App\Models\RegisterHardware;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all hardware', function () {
    Hardware::factory()->count(3)->create();

    $response = $this->getJson(route('hardware.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('A Hardware Register can have many Hardware', function () {
    $register = RegisterHardware::factory()->create();

    $hardware1 = Hardware::factory()->create(['id_RH' => $register->id]);
    $hardware2 = Hardware::factory()->create(['id_RH' => $register->id]);

    $register->load('hardwares');

    $this->assertCount(2, $register->hardwares);
    $this->assertTrue($register->hardwares->contains($hardware1));
    $this->assertTrue($register->hardwares->contains($hardware2));
});

it('create a new hardware', function () {
    $register = RegisterHardware::factory()->create();

    $data = Hardware::factory()->make([
        'id_RH' => $register->id,
    ])->toArray();

    $response = $this->postJson(route('hardware.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['serial_number' => $data['serial_number']]);

    $this->assertDatabaseHas('hardwares', ['serial_number' => $data['serial_number']]);
});

it('show a specific hardware', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->getJson(route('hardware.show',['hardware'=>$hardware->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $hardware->id]);
});

it('Update a hardware', function () {
    $hardware = Hardware::factory()->create();

    $newSupplier = 'Proveedor Actualizado S.A.';
    $response = $this->putJson(route('hardware.update',['hardware'=>$hardware->id]), [
        ...$hardware->toArray(),
        'supplier' => $newSupplier,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('hardwares', ['supplier' => $newSupplier]);
});

it('Delete a hardware', function () {
    $hardware = Hardware::factory()->create();

    $response = $this->deleteJson(route('hardware.destroy',['hardware'=>$hardware->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('hardwares', ['id' => $hardware->id]);
});
