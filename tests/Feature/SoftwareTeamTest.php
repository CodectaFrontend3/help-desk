<?php

use App\Models\SoftwareTeam;
use App\Models\Software;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all software teams', function () {
    SoftwareTeam::factory()->count(3)->create();

    $response = $this->getJson(route('softwareTeam.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a team can have many software teams',function(){
    $team = Team::factory()->create();

    $softwareTeam1= SoftwareTeam::factory()->create(['id_team' => $team->id]);
    $softwareTeam2= SoftwareTeam::factory()->create(['id_team' => $team->id]);

    $team->load('softwareTeams');

    $this->assertCount(2,$team->softwareTeams);

    $this->assertTrue($team->softwareTeams->contains($softwareTeam1));
    $this->assertTrue($team->softwareTeams->contains($softwareTeam2));
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
    $team = Team::factory()->create();

    $data = [
        'id_software' => $software->id,
        'id_team' => $team->id,
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
    $newTeam = Team::factory()->create();

    $data = [
        'id_software' => $newSoftware->id,
        'id_team' => $newTeam->id,
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
