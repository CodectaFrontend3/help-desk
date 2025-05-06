<?php

use App\Models\SoftwareEquipo;
use App\Models\Software;
use App\Models\Equipo;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('lista todos los software_equipo', function () {
    SoftwareEquipo::factory()->count(3)->create();

    $response = $this->getJson(route('softwareEquipo.index'));

    $response->assertOk();
    $response->assertJsonCount(3);
});

it('un equipo puede tener varios software_equipo',function(){
    $equipo = Equipo::factory()->create();

    $softwareEquipo1= SoftwareEquipo::factory()->create(['id_equipos' => $equipo->id]);
    $softwareEquipo2= SoftwareEquipo::factory()->create(['id_equipos' => $equipo->id]);

    $equipo->load('softwareEquipo');

    $this->assertCount(2,$equipo->softwareEquipo);

    $this->assertTrue($equipo->softwareEquipo->contains($softwareEquipo1));
    $this->assertTrue($equipo->softwareEquipo->contains($softwareEquipo2));
});

it('un software puede tener muchos software_equipo',function(){
    $software = Software::factory()->create();

    $softwareEquipo1= SoftwareEquipo::factory()->create(['id_software' => $software->id]);
    $softwareEquipo2= SoftwareEquipo::factory()->create(['id_software' => $software->id]);

    $software->load('softwareEquipo');

    $this->assertCount(2,$software->softwareEquipo);

    $this->assertTrue($software->softwareEquipo->contains($softwareEquipo1));
    $this->assertTrue($software->softwareEquipo->contains($softwareEquipo2));
});

it('crear un nuevo software_equipo', function () {
    $software = Software::factory()->create();
    $equipo = Equipo::factory()->create();

    $data = [
        'id_software' => $software->id,
        'id_equipos' => $equipo->id,
    ];

    $response = $this->postJson(route('softwareEquipo.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment($data);

    $this->assertDatabaseHas('software_equipo', $data);
});

it('mostrar un software_equipo específico', function () {
    $softwareEquipo = SoftwareEquipo::factory()->create();

    $response = $this->getJson(route('softwareEquipo.show', ['softwareEquipo' => $softwareEquipo->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $softwareEquipo->id]);
});

it('actualizar un software_equipo', function () {
    $softwareEquipo = SoftwareEquipo::factory()->create();

    $nuevoSoftware = Software::factory()->create();
    $nuevoEquipo = Equipo::factory()->create();

    $data = [
        'id_software' => $nuevoSoftware->id,
        'id_equipos' => $nuevoEquipo->id,
    ];

    $response = $this->putJson(route('softwareEquipo.update', ['softwareEquipo' => $softwareEquipo->id]), $data);

    $response->assertOk();
    $this->assertDatabaseHas('software_equipo', $data);
});

it('eliminar un software_equipo', function () {
    $softwareEquipo = SoftwareEquipo::factory()->create();

    $response = $this->deleteJson(route('softwareEquipo.destroy', ['softwareEquipo' => $softwareEquipo->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('software_equipo', ['id' => $softwareEquipo->id]);
});
