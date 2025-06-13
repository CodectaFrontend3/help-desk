<?php

use App\Models\NaturalPerson;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("NaturalPerson");});

it('list all natural persons', function () {
    NaturalPerson::factory()->count(3)->create();

    $response = $this->getJson(route('natural-person.index'));

    $response->assertOk()
             ->assertJsonCount(3);
});

test('create a natural person', function () {
    $data = [
        'name' => 'Juan Pérez',
        'dni' => '12345678',
        'phone' => '987654321',
        'email' => 'juan@correo.com',
    ];

    $response = $this->postJson(route('natural-person.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('natural_persons', $data);
});

test('show a specific natural person', function () {
    $person = NaturalPerson::factory()->create();

    $response = $this->getJson(route('natural-person.show', ['natural_person' => $person->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $person->id,
                 'name' => $person->name,
             ]);
});

test('update a natural person', function () {
    $person = NaturalPerson::factory()->create();

    $nuevosDatos = [
        'name' => 'Luis Gómez',
        'dni' => '87654321',
        'phone' => '123123123',
        'email' => 'luis@correo.com',
    ];

    $response = $this->putJson(route('natural-person.update', ['natural_person' => $person->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('natural_persons', $nuevosDatos);
});

test('delete a natural person', function () {
    $person = NaturalPerson::factory()->create();

    $response = $this->deleteJson(route('natural-person.destroy', ['natural_person' => $person->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('natural_persons', ['id' => $person->id]);
});
