<?php

use App\Models\AccountRegister;
use App\Models\ClientG;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista de todas las cuentas registradas', function () {
    AccountRegister::factory()->count(3)->create();

    $response = $this->getJson(route('accountRegister.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('registrar una nueva cuenta registro', function () {
    $client = ClientG::factory()->create();

    $data = [
        'id_clientG' => $client->id,
        'email' => 'prueba@gmail.com',
        'password' => 'a12345678955'
    ];

    $response = $this->postJson(route('accountRegister.store'), $data);

    $response->assertCreated();
    $this->assertDatabaseHas('account_register', $data);
});

it('un clienteG puede tener una cuenta registrada', function () {
    $client = ClientG::factory()->create();

    $account = AccountRegister::factory()->create([
        'id_clientG' => $client->id
    ]);

    $client->load('AccountRegister');

    $this->assertNotNull($client->AccountRegister);
    $this->assertTrue($client->AccountRegister->is($account));
});

it('mostrar una cuenta específica', function () {
    $account = AccountRegister::factory()->create();

    $response = $this->getJson(route('accountRegister.show',['accountRegister'=>$account->id]));

    $response->assertOk()
        ->assertJson([
        'id' => $account->id,
        'email' => $account->email,
    ]);
});

it('actualizar una cuenta', function () {
    $account = AccountRegister::factory()->create();
    $newClient = ClientG::factory()->create();

    $data = [
        'id_clientG' => $newClient->id,
        'email' => 'nuevo@gmail.com',
        'password' => 'a12345678955'
    ];

    $response = $this->putJson(route('accountRegister.update',['accountRegister'=>$account->id]), $data);

    $response->assertNoContent();
    $this->assertDatabaseHas('account_register', array_merge(['id' => $account->id], $data));
});

it('eliminar una cuenta', function () {
    $account = AccountRegister::factory()->create();

    $response = $this->deleteJson(route('accountRegister.destroy',['accountRegister'=>$account->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('account_register', ['id' => $account->id]);
});
