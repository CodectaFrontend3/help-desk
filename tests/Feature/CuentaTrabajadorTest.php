<?php

use App\Models\CuentaTrabajador;
use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todas las cuentas de trabajador', function () {
    CuentaTrabajador::factory()->count(3)->create();

    $response = $this->getJson(route('cuentaTrabajador.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('un equipo puede tener una cuentaTrabajador',function(){
    $equipo = Equipo::factory()->create();
    $cuentaTrabajador = CuentaTrabajador::factory()->create(['id_equipos'=>$equipo->id]);

    $equipo->load('cuentaTrabajador');

    $this->assertNotNull($equipo->cuentaTrabajador);
    $this->assertTrue($equipo->cuentaTrabajador->is($cuentaTrabajador));

});

it('crear una nueva cuenta de trabajador', function () {
    $equipo = Equipo::factory()->create();

    $data = CuentaTrabajador::factory()->make([
        'id_equipos' => $equipo->id,
    ])->toArray();

    $response = $this->postJson(route('cuentaTrabajador.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['nombre_usuario' => $data['nombre_usuario']]);

    $this->assertDatabaseHas('cuenta_trabajador', ['nombre_usuario' => $data['nombre_usuario']]);
});

it('mostrar una cuenta de trabajador específica', function () {
    $cuenta = CuentaTrabajador::factory()->create();

    $response = $this->getJson(route('cuentaTrabajador.show', ['cuentaTrabajador' => $cuenta->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $cuenta->id]);
});

it('actualizar una cuenta de trabajador', function () {
    $cuenta = CuentaTrabajador::factory()->create();

    $nuevaArea = 'Recursos Humanos';
    $response = $this->putJson(route('cuentaTrabajador.update', ['cuentaTrabajador' => $cuenta->id]), [
        ...$cuenta->toArray(),
        'area' => $nuevaArea,
    ]);

    $response->assertOk();
    $this->assertDatabaseHas('cuenta_trabajador', ['area' => $nuevaArea]);
});

it('eliminar una cuenta de trabajador', function () {
    $cuenta = CuentaTrabajador::factory()->create();

    $response = $this->deleteJson(route('cuentaTrabajador.destroy', ['cuentaTrabajador' => $cuenta->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('cuenta_trabajador', ['id' => $cuenta->id]);
});
