<?php
use App\Models\Equipo;
use App\Models\ClienteG;
use App\Models\Empresa;
use App\Models\MicroEmpresa;
use App\Models\PersonaNatural;
use App\Models\Plan;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todos los equipos', function () {
    Equipo::factory()->count(3)->create();

    $response = $this->getJson(route('equipo.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('crear un nuevo equipo', function () {
    $cliente = ClienteG::factory()->create();
    $empresa = Empresa::factory()->create();
    $microempresa = MicroEmpresa::factory()->create();
    $persona = PersonaNatural::factory()->create();
    $plan = Plan::factory()->create();

    $data = [
        'id_clienteG' => $cliente->id,
        'id_empresa' => $empresa->id,
        'id_microempresa' => $microempresa->id,
        'id_personaN' => $persona->id,
        'id_plan' => $plan->id,
        'tipo' => 'Laptop',
        'marca' => 'HP',
        'nombre_usuario' => 'usuario_123',
        'ult_revision' => now()->subDays(5)->toDateTimeString(),
        'revision_programada' => now()->addDays(30)->toDateTimeString(),
    ];

    $response = $this->postJson(route('equipo.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['nombre_usuario' => $data['nombre_usuario']]);

    $this->assertDatabaseHas('equipo', $data);
});

it('mostrar un equipo específico', function () {
    $equipo = Equipo::factory()->create();

    $response = $this->getJson(route('equipo.show', ['equipo' => $equipo->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $equipo->id]);
});

it('actualizar un equipo', function () {
    $equipo = Equipo::factory()->create();

    $nuevaMarca = 'Dell Actualizado';
    $data = [
        ...$equipo->toArray(),
        'marca' => $nuevaMarca,
    ];

    $response = $this->putJson(route('equipo.update', ['equipo' => $equipo->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('equipo', ['marca' => $nuevaMarca]);
});

it('eliminar un equipo', function () {
    $equipo = Equipo::factory()->create();

    $response = $this->deleteJson(route('equipo.destroy', ['equipo' => $equipo->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('equipo', ['id' => $equipo->id]);
});
