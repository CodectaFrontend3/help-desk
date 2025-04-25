<?php
use App\Models\ClienteG;

use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista de todos los clientes g',function(){
    ClienteG::factory()->count(3)->create();

    $response = $this->getJson(route('clienteG.index'));

    $response->assertOk()
            ->assertJsonCount(3);
});



test('crear un cliente_g', function () {
    $data = [
        'nombre' => 'Juan',
        'apellido' => 'Perz',
        'direccion' => 'Calle Falsa 123',
        'correo' => 'juan@gmail.com',
        'num_telefono' => '123456789',
        'numero_plan' => 1,
    ];

    $response = $this->postJson(route('clienteG.store'), $data);

    $response->assertCreated()
             ->assertJsonFragment($data);

    $this->assertDatabaseHas('cliente_g', $data);
});

test('mostrar un cliente g específico', function () {
    $cliente = ClienteG::factory()->create();

    $response = $this->getJson(route('clienteG.show',['clienteG'=>$cliente->id]));

    $response->assertOk()
             ->assertJsonFragment([
                 'id' => $cliente->id,
                 'nombre' => $cliente->nombre,
             ]);
});

test('actualizar un cliente g', function () {
    $cliente = ClienteG::factory()->create();

    $nuevosDatos = [
        'nombre' => 'Pedro',
        'apellido' => 'López',
        'direccion' => 'Nueva dirección',
        'correo' => 'pedro@gmail.com',
        'num_telefono' => '987654321',
        'numero_plan' => 2,
    ];

    $response = $this->putJson(route('clienteG.update',['clienteG'=>$cliente->id]), $nuevosDatos);

    $response->assertNoContent();

    $this->assertDatabaseHas('cliente_g', $nuevosDatos);
});

test('eliminar un cliente_g', function () {
    $cliente = ClienteG::factory()->create();

    $response = $this->deleteJson(route('clienteG.destroy',['clienteG'=>$cliente->id]));

    $response->assertNoContent();

    $this->assertDatabaseMissing('cliente_g', ['id' => $cliente->id]);
});

