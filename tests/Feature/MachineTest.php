<?php

use App\Models\ClientG;
use App\Models\Company;
use App\Models\Machine;
use App\Models\NaturalPerson;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lists all machines', function () {
    Machine::factory()->count(3)->create();

    $response = $this->getJson(route('machine.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('a clientG can have multiple machines', function () {
    $client = ClientG::factory()->create();

    $machine1 = Machine::factory()->create(['id_clientG' => $client->id]);
    $machine2 = Machine::factory()->create(['id_clientG' => $client->id]);

    $client->load('machines');

    $this->assertCount(2, $client->machines);
    $this->assertTrue($client->machines->contains($machine1));
    $this->assertTrue($client->machines->contains($machine2));
});

it('a company can have multiple machines', function () {
    $company = Company::factory()->create();

    $machine1 = Machine::factory()->create(['id_company' => $company->id]);
    $machine2 = Machine::factory()->create(['id_company' => $company->id]);

    $company->load('machines');

    $this->assertCount(2, $company->machines);
    $this->assertTrue($company->machines->contains($machine1));
    $this->assertTrue($company->machines->contains($machine2));
});


it('a natural person can have multiple machines', function () {
    $person = NaturalPerson::factory()->create();

    $machine1 = Machine::factory()->create(['id_personN' => $person->id]);
    $machine2 = Machine::factory()->create(['id_personN' => $person->id]);

    $person->load('machines');

    $this->assertCount(2, $person->machines);
    $this->assertTrue($person->machines->contains($machine1));
    $this->assertTrue($person->machines->contains($machine2));
});

it('a plan can have multiple machines', function () {
    $plan = Plan::factory()->create();

    $machine1 = Machine::factory()->create(['id_plan' => $plan->id]);
    $machine2 = Machine::factory()->create(['id_plan' => $plan->id]);

    $plan->load('machines');

    $this->assertCount(2, $plan->machines);
    $this->assertTrue($plan->machines->contains($machine1));
    $this->assertTrue($plan->machines->contains($machine2));
});

it('create a new machine', function () {
    $client = ClientG::factory()->create();
    $company = Company::factory()->create();
    $person = NaturalPerson::factory()->create();
    $plan = Plan::factory()->create();

    $data = [
        'id_clientG' => $client->id,
        'id_company' => $company->id,
        'id_personN' => $person->id,
        'id_plan' => $plan->id,
        'type' => 'Laptop',
        'brand' => 'HP',
        'username' => 'user_123',
        'end_revision' => now()->subDays(5)->toDateTimeString(),
        'revision_scheduled' => now()->addDays(30)->toDateTimeString(),
    ];

    $response = $this->postJson(route('machine.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['username' => $data['username']]);

    $this->assertDatabaseHas('machines', $data);
});

it('show a specific machine', function () {
    $machine = Machine::factory()->create();

    $response = $this->getJson(route('machine.show', ['machine' => $machine->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $machine->id]);
});

it('update a machine', function () {
    $machine = Machine::factory()->create();

    $newBrand = 'Dell Updated';
    $data = [
        ...$machine->toArray(),
        'brand' => $newBrand,
    ];

    $response = $this->putJson(route('machine.update', ['machine' => $machine->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('machines', ['brand' => $newBrand]);
});

it('delete a machine', function () {
    $machine = Machine::factory()->create();

    $response = $this->deleteJson(route('machine.destroy', ['machine' => $machine->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('machines', ['id' => $machine->id]);
});

