<?php

use App\Models\Machine;
use App\Models\SoftwareTeam;
use App\Models\Software;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all software teams', function () {
    SoftwareTeam::factory()->count(3)->create();

    $response = $this->getJson(route('softwareTeam.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a machine can have many software teams',function(){
    $machine = Machine::factory()->create();

    $softwareTeam1= SoftwareTeam::factory()->create(['id_machine' => $machine->id]);
    $softwareTeam2= SoftwareTeam::factory()->create(['id_machine' => $machine->id]);

    $machine->load('softwareTeams');

    $this->assertCount(2,$machine->softwareTeams);

    $this->assertTrue($machine->softwareTeams->contains($softwareTeam1));
    $this->assertTrue($machine->softwareTeams->contains($softwareTeam2));
});

it('a software can have many software teams',function(){
    $software = Software::factory()->create();

    $softwareTeam1= SoftwareTeam::factory()->create(['id_software' => $software->id]);
    $softwareTeam2= SoftwareTeam::factory()->create(['id_software' => $software->id]);

    $software->load('softwareTeams');

    $this->assertCount(2,$software->softwareTeams);

    $this->assertTrue($software->softwareTeams->contains($softwareTeam1));
    $this->assertTrue($software->softwareTeams->contains($softwareTeam2));
});

it('create a new software team', function () {
    $software = Software::factory()->create();
    $machine = Machine::factory()->create();

    $data = [
        'id_software' => $software->id,
        'id_machine' => $machine->id,
    ];

    $response = $this->postJson(route('softwareTeam.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment($data);

    $this->assertDatabaseHas('software_teams', $data);
});

it('show a specify software team', function () {
    $softwareTeam = SoftwareTeam::factory()->create();

    $response = $this->getJson(route('softwareTeam.show', ['softwareTeam' => $softwareTeam->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $softwareTeam->id]);
});

it('update a software team', function () {
    $softwareTeam = SoftwareTeam::factory()->create();

    $newSoftware = Software::factory()->create();
    $newMachine = Machine::factory()->create();

    $data = [
        'id_software' => $newSoftware->id,
        'id_machine' => $newMachine->id,
    ];

    $response = $this->putJson(route('softwareTeam.update', ['softwareTeam' => $softwareTeam->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('software_teams', $data);
});

it('delete a software team', function () {
    $softwareTeam = SoftwareTeam::factory()->create();

    $response = $this->deleteJson(route('softwareTeam.destroy', ['softwareTeam' => $softwareTeam->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('software_teams', ['id' => $softwareTeam->id]);
});
