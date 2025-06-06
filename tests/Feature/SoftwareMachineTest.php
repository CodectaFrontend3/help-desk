<?php

use App\Models\Machine;
use App\Models\SoftwareMachine;
use App\Models\Software;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("SoftwareMachine");});

it('list of all software machines', function () {
    SoftwareMachine::factory()->count(3)->create();

    $response = $this->getJson(route('softwareMachine.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a machine can have many software machines',function(){
    $machine = Machine::factory()->create();

    $softwareMachine1= SoftwareMachine::factory()->create(['id_machine' => $machine->id]);
    $softwareMachine2= SoftwareMachine::factory()->create(['id_machine' => $machine->id]);

    $machine->load('softwareMachines');

    $this->assertCount(2,$machine->softwareMachines);

    $this->assertTrue($machine->softwareMachines->contains($softwareMachine1));
    $this->assertTrue($machine->softwareMachines->contains($softwareMachine2));
});

it('a software can have many software machines',function(){
    $software = Software::factory()->create();

    $softwareMachine1= SoftwareMachine::factory()->create(['id_software' => $software->id]);
    $softwareMachine2= SoftwareMachine::factory()->create(['id_software' => $software->id]);

    $software->load('softwareMachines');

    $this->assertCount(2,$software->softwareMachines);

    $this->assertTrue($software->softwareMachines->contains($softwareMachine1));
    $this->assertTrue($software->softwareMachines->contains($softwareMachine2));
});

it('create a new software Machine', function () {
    $software = Software::factory()->create();
    $machine = Machine::factory()->create();

    $data = [
        'id_software' => $software->id,
        'id_machine' => $machine->id,
    ];

    $response = $this->postJson(route('softwareMachine.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment($data);

    $this->assertDatabaseHas('software_machines', $data);
});

it('show a specify software machine', function () {
    $softwareMachine = SoftwareMachine::factory()->create();

    $response = $this->getJson(route('softwareMachine.show', ['softwareMachine' => $softwareMachine->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $softwareMachine->id]);
});

it('update a software Machine', function () {
    $softwareMachine = SoftwareMachine::factory()->create();

    $newSoftware = Software::factory()->create();
    $newMachine = Machine::factory()->create();

    $data = [
        'id_software' => $newSoftware->id,
        'id_machine' => $newMachine->id,
    ];

    $response = $this->putJson(route('softwareMachine.update', ['softwareMachine' => $softwareMachine->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('software_machines', $data);
});

it('delete a software machine', function () {
    $softwareMachine = SoftwareMachine::factory()->create();

    $response = $this->deleteJson(route('softwareMachine.destroy', ['softwareMachine' => $softwareMachine->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('software_machines', ['id' => $softwareMachine->id]);
});
