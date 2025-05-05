<?php

use App\Models\AccountWorker;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all workers account', function () {
    AccountWorker::factory()->count(3)->create();

    $response = $this->getJson(route('accountWorker.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a team can have a  worker account',function(){
    $equipo = Team::factory()->create();
    $cuentaTrabajador = AccountWorker::factory()->create(['id_team'=>$equipo->id]);

    $equipo->load('accountWorkers');

    $this->assertNotNull($equipo->accountWorkers);
    $this->assertTrue($equipo->accountWorkers->is($cuentaTrabajador));

});

it('create a new worker account', function () {
    $equipo = Team::factory()->create();

    $data = AccountWorker::factory()->make([
        'id_team' => $equipo->id,
    ])->toArray();

    $response = $this->postJson(route('accountWorker.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['username' => $data['username']]);

    $this->assertDatabaseHas('account_workers', ['username' => $data['username']]);
});

it('show a specify worker account', function () {
    $cuenta = AccountWorker::factory()->create();

    $response = $this->getJson(route('accountWorker.show', ['accountWorker' => $cuenta->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $cuenta->id]);
});

it('update a worker account', function () {
    $cuenta = AccountWorker::factory()->create();

    $nuevaArea = 'Recursos Humanos';
    $response = $this->putJson(route('accountWorker.update', ['accountWorker' => $cuenta->id]), [
        ...$cuenta->toArray(),
        'area' => $nuevaArea,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('account_workers', ['area' => $nuevaArea]);
});

it('delete a worker account', function () {
    $cuenta = AccountWorker::factory()->create();

    $response = $this->deleteJson(route('accountWorker.destroy', ['accountWorker' => $cuenta->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('account_workers', ['id' => $cuenta->id]);
});
