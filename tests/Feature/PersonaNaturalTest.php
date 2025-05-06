<?php
use App\Models\PersonaNatural;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('puede listar personas naturales', function () {
    PersonaNatural::factory()->count(3)->create();

    $response = $this->getJson(route('personaNatural.index'));

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

test('crear una persona natural', function () {
    $data = [
        'dni' => '12345678',
        'nombre' => 'Juan Pérez',
        'telefono' => '987654321',
        'correo' => 'juanperez@mail.com',
    ];

    $response = $this->postJson(route('personaNatural.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment(['dni' => $data['dni']]);

    $this->assertDatabaseHas('persona_natural', $data);
});

test('mostrar una persona natural específica', function () {
    $persona = PersonaNatural::factory()->create();

    $response = $this->getJson(route('personaNatural.show', ['personaNatural' => $persona->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $persona->id,
                 'dni' => $persona->dni,
             ]);
});

test('actualizar una persona natural', function () {
    $persona = PersonaNatural::factory()->create();

    $nuevosDatos = [
        'dni' => '87654321',
        'nombre' => 'Nombre Actualizado',
        'telefono' => '123456789',
        'correo' => 'actualizado@mail.com',
    ];

    $response = $this->putJson(route('personaNatural.update', ['personaNatural' => $persona->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('persona_natural', $nuevosDatos);
});

test('eliminar una persona natural', function () {
    $persona = PersonaNatural::factory()->create();

    $response = $this->deleteJson(route('personaNatural.destroy', ['personaNatural' => $persona->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('persona_natural', ['id' => $persona->id]);
});
