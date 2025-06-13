<?php
use App\Models\ClientG;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

beforeEach(function () {$this->setTestUserWithPermissions("ClientG");});

it('list of all clients g',function(){
    ClientG::factory()->count(3)->create();

    $response = $this->getJson(route('clientG.index'));

    $response->assertOk()
            ->assertJsonCount(3);
});



test('create a new clients g', function () {
    $data = [
        'name' => 'Juan',
        'last_name' => 'Perz',
        'address' => 'Calle Falsa 123',
        'email' => 'juan@gmail.com',
        'phone_number' => '123456789',
        'plan_number' => 1,
    ];

    $response = $this->postJson(route('clientG.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('clients_g', $data);
});

test('show a specific client g', function () {
    $client = ClientG::factory()->create();

    $response = $this->getJson(route('clientG.show',['clientG'=>$client->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $client->id,
                 'name' => $client->name,
             ]);
});

test('update a client g', function () {
    $client = ClientG::factory()->create();

    $nuevosDatos = [
        'name' => 'Pedro',
        'last_name' => 'López',
        'address' => 'Nueva dirección',
        'email' => 'pedro@gmail.com',
        'phone_number' => '987654321',
        'plan_number' => 2,
    ];

    $response = $this->putJson(route('clientG.update',['clientG'=>$client->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('clients_g', $nuevosDatos);
});

test('delete a client g', function () {
    $client = ClientG::factory()->create();

    $response = $this->deleteJson(route('clientG.destroy',['clientG'=>$client->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('clients_g', ['id' => $client->id]);
});

