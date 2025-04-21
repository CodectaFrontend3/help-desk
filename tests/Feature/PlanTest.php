<?php

use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('puede listar todos los planes', function () {
    Plan::factory()->count(3)->create();

    $response = $this->getJson('/api/planes');

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('puede crear un nuevo plan', function () {
    $data = [
        'numero_plan' => 101,
        'nombre' => 'Plan Básico',
        'descripcion' => 'Este es un plan de prueba.'
    ];

    $response = $this->postJson('/api/planes', $data);

    $response->assertCreated();
    $this->assertDatabaseHas('planes', $data);
});

it('puede mostrar un plan específico', function () {
    $plan = Plan::factory()->create();

    $response = $this->getJson("/api/planes/{$plan->id}");

    $response->assertOk();
    $response->assertJson([
        'id' => $plan->id,
        'nombre' => $plan->nombre,
        'descripcion' => $plan->descripcion
    ]);
});

it('puede actualizar un plan', function () {
    $plan = Plan::factory()->create();

    $newData = [
        'numero_plan' => 202,
        'nombre' => 'Plan Actualizado',
        'descripcion' => 'Descripción actualizada.'
    ];

    $response = $this->putJson("/api/planes/{$plan->id}", $newData);

    $response->assertNoContent();
    $this->assertDatabaseHas('planes', array_merge(['id' => $plan->id], $newData));
});

it('puede eliminar un plan', function () {
    $plan = Plan::factory()->create();

    $response = $this->deleteJson("/api/planes/{$plan->id}");

    $response->assertNoContent();
    $this->assertDatabaseMissing('planes', ['id' => $plan->id]);
});