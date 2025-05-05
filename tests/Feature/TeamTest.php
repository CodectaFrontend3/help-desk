<?php

use App\Models\Team;
use App\Models\ClientG;
use App\Models\Company;
use App\Models\MicroCompany;
use App\Models\NaturalPerson;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists all teams', function () {
    Team::factory()->count(3)->create();

    $response = $this->getJson(route('team.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a clientG can have multiple teams', function () {
    $client = ClientG::factory()->create();

    $team1 = Team::factory()->create(['id_clientG' => $client->id]);
    $team2 = Team::factory()->create(['id_clientG' => $client->id]);

    $client->load('teams');

    $this->assertCount(2, $client->teams);
    $this->assertTrue($client->teams->contains($team1));
    $this->assertTrue($client->teams->contains($team2));
});

it('a company can have multiple teams', function () {
    $company = Company::factory()->create();

    $team1 = Team::factory()->create(['id_company' => $company->id]);
    $team2 = Team::factory()->create(['id_company' => $company->id]);

    $company->load('teams');

    $this->assertCount(2, $company->teams);
    $this->assertTrue($company->teams->contains($team1));
    $this->assertTrue($company->teams->contains($team2));
});

it('a microcompany can have multiple teams', function () {
    $microcompany = MicroCompany::factory()->create();

    $team1 = Team::factory()->create(['id_microcompany' => $microcompany->id]);
    $team2 = Team::factory()->create(['id_microcompany' => $microcompany->id]);

    $microcompany->load('teams');

    $this->assertCount(2, $microcompany->teams);
    $this->assertTrue($microcompany->teams->contains($team1));
    $this->assertTrue($microcompany->teams->contains($team2));
});

it('a natural person can have multiple teams', function () {
    $person = NaturalPerson::factory()->create();

    $team1 = Team::factory()->create(['id_personN' => $person->id]);
    $team2 = Team::factory()->create(['id_personN' => $person->id]);

    $person->load('teams');

    $this->assertCount(2, $person->teams);
    $this->assertTrue($person->teams->contains($team1));
    $this->assertTrue($person->teams->contains($team2));
});

it('a plan can have multiple teams', function () {
    $plan = Plan::factory()->create();

    $team1 = Team::factory()->create(['id_plan' => $plan->id]);
    $team2 = Team::factory()->create(['id_plan' => $plan->id]);

    $plan->load('teams');

    $this->assertCount(2, $plan->teams);
    $this->assertTrue($plan->teams->contains($team1));
    $this->assertTrue($plan->teams->contains($team2));
});

it('create a new team', function () {
    $client = ClientG::factory()->create();
    $company = Company::factory()->create();
    $microcompany = MicroCompany::factory()->create();
    $person = NaturalPerson::factory()->create();
    $plan = Plan::factory()->create();

    $data = [
        'id_clientG' => $client->id,
        'id_company' => $company->id,
        'id_microcompany' => $microcompany->id,
        'id_personN' => $person->id,
        'id_plan' => $plan->id,
        'type' => 'Laptop',
        'brand' => 'HP',
        'username' => 'user_123',
        'end_revision' => now()->subDays(5)->toDateTimeString(),
        'revision_scheduled' => now()->addDays(30)->toDateTimeString(),
    ];

    $response = $this->postJson(route('team.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['username' => $data['username']]);

    $this->assertDatabaseHas('teams', $data);
});

it('show a specific team', function () {
    $team = Team::factory()->create();

    $response = $this->getJson(route('team.show', ['team' => $team->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $team->id]);
});

it('update a team', function () {
    $team = Team::factory()->create();

    $newBrand = 'Dell Updated';
    $data = [
        ...$team->toArray(),
        'brand' => $newBrand,
    ];

    $response = $this->putJson(route('team.update', ['team' => $team->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('teams', ['brand' => $newBrand]);
});

it('delete a team', function () {
    $team = Team::factory()->create();

    $response = $this->deleteJson(route('team.destroy', ['team' => $team->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('teams', ['id' => $team->id]);
});

