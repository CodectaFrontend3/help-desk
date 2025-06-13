<?php

use App\Models\RegisterHardware;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("RegisterHardware");});

it('list of all register hardwares', function () {
    RegisterHardware::factory()->count(3)->create();

    $response = $this->getJson(route('registerHardware.index'));

    $response->assertOk()
            ->assertJsonCount(3);
});


it('create a register hardware', function () {
    $register = RegisterHardware::factory()->make()->toArray();

    $response = $this->postJson(route('registerHardware.store'), $register);

    $response->assertCreated();
    $response->assertJsonFragment(['serie' => $register['serie']]);
    $this->assertDatabaseHas('register_hardwares', ['serie' => $register['serie']]);
});

it('show a specific register hardware', function () {
    $register = RegisterHardware::factory()->create();

    $response = $this->getJson(route('registerHardware.show',['registerHardware'=>$register->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $register->id]);
});

it('update a register hardware', function () {
    $register = RegisterHardware::factory()->create();

    $newSupplier = 'Proveedor S.A.C.';
    $response = $this->putJson(route('registerHardware.update',['registerHardware'=>$register->id]), [
        ...$register->toArray(),
        'supplier' => $newSupplier,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('register_hardwares', ['supplier' => $newSupplier]);
});

it('delete a register hardware', function () {
    $register = RegisterHardware::factory()->create();

    $response = $this->deleteJson(route('registerHardware.destroy',['registerHardware'=>$register->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('register_hardwares', ['id' => $register->id]);
});
