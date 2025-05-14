<?php

use App\Models\AccountWorker;
use App\Models\Machine;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all workers account', function () {
    AccountWorker::factory()->count(3)->create();

    $response = $this->getJson(route('accountWorker.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a machine can have a  worker account',function(){
    $machine = Machine::factory()->create();
    $accountWorker = AccountWorker::factory()->create(['id_machine'=>$machine->id]);

    $machine->load('accountWorkers');

    $this->assertNotNull($machine->accountWorkers);
    $this->assertTrue($machine->accountWorkers->is($accountWorker));

});

it('create a new worker account', function () {
    $machine = Machine::factory()->create();

    $data = AccountWorker::factory()->make([
        'id_machine' => $machine->id,
    ])->toArray();

    $response = $this->postJson(route('accountWorker.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['username' => $data['username']]);

    $this->assertDatabaseHas('account_workers', ['username' => $data['username']]);
});

it('show a specify worker account', function () {
    $account = AccountWorker::factory()->create();

    $response = $this->getJson(route('accountWorker.show', ['accountWorker' => $account->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $account->id]);
});

it('update a worker account', function () {
    $account = AccountWorker::factory()->create();

    $newArea = 'Recursos Humanos';
    $response = $this->putJson(route('accountWorker.update', ['accountWorker' => $account->id]), [
        ...$account->toArray(),
        'area' => $newArea,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('account_workers', ['area' => $newArea]);
});

it('delete a worker account', function () {
    $account = AccountWorker::factory()->create();

    $response = $this->deleteJson(route('accountWorker.destroy', ['accountWorker' => $account->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('account_workers', ['id' => $account->id]);
});
