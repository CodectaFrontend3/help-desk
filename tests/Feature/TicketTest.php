<?php

use App\Models\Ticket;
use App\Models\Team;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

// Test: crear un ticket
it('create a ticket', function () {
    $team = Team::factory()->create();

    $response = $this->postJson('/api/tickets', [
        'team_id' => $team->id,
        'incident_type' => 'Network',
        'client_name' => 'Carlos Ruiz',
        'company' => 'Empresa X',
        'area' => 'Soporte',
        'branch' => 'Sucursal Lima',
        'state' => 'Abierto',
        'registration_date' => '2025-05-05',
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment([
                 'client_name' => 'Carlos Ruiz',
                 'state' => 'Abierto',
             ]);

    expect(Ticket::count())->toBe(1);
});

// Test: listar todos los tickets
it('list all tickets', function () {
    Ticket::factory()->count(3)->create();

    $response = $this->getJson('/api/tickets');

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

// Test: ver un ticket específico
it('muestra un ticket por su ID', function () {
    $ticket = Ticket::factory()->create([
        'client_name' => 'Ana Torres',
        'state' => 'En Proceso',
    ]);

    $response = $this->getJson("/api/tickets/{$ticket->id}");

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'client_name' => 'Ana Torres',
                 'state' => 'En Proceso',
             ]);
});

// Test: actualizar un ticket
it('update a ticket', function () {
    $ticket = Ticket::factory()->create();

    $response = $this->putJson("/api/tickets/{$ticket->id}", [
        'team_id' => $ticket->team_id,
        'incident_type' => 'Hardware',
        'client_name' => 'María López',
        'company' => 'Tech SA',
        'area' => 'TI',
        'branch' => 'Sucursal Sur',
        'state' => 'Cerrado',
        'registration_date' => '2025-05-05',
    ]);

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'client_name' => 'María López',
                 'state' => 'Cerrado',
             ]);
});

// Test: eliminar un ticket
it('delete a ticket', function () {
    $ticket = Ticket::factory()->create();

    $response = $this->deleteJson("/api/tickets/{$ticket->id}");

    $response->assertNoContent();

    expect(Ticket::count())->toBe(0);
});
