<?php

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("Plan");});

it('list of all plans', function () {
    Plan::factory()->count(3)->create();

    $response = $this->getJson(route('plan.index'));

    $response->assertOk()->assertJsonCount(3);
});

it('create a new plan', function () {
    $data = [
        'plan_number' => 101,
        'name' => 'Plan Básico',
        'description' => 'Este es un plan de prueba.'
    ];

    $response = $this->postJson(route('plan.store'), $data);

    $response->assertCreated();
    $this->assertDatabaseHas('plans', $data);
});

it('show a specific plan', function () {
    $plan = Plan::factory()->create();

    $response = $this->getJson(route('plan.show',['plan'=>$plan->id]));

    $response->assertOk()->assertJson([
        'id' => $plan->id,
        'name' => $plan->name,
        'description' => $plan->description
    ]);
});

it('update a plan', function () {
    $plan = Plan::factory()->create();

    $newData = [
        'plan_number' => 202,
        'name' => 'Plan Actualizado',
        'description' => 'Descripción actualizada.'
    ];

    $response = $this->putJson(route('plan.update',['plan'=>$plan->id]), $newData);

    $response->assertNoContent();
    $this->assertDatabaseHas('plans', array_merge(['id' => $plan->id], $newData));
});

it('delete a plan', function () {
    $plan = Plan::factory()->create();

    $response = $this->deleteJson(route('plan.destroy',['plan'=>$plan->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('plans', ['id' => $plan->id]);
});