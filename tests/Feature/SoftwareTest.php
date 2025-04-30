<?php

use App\Models\Software;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);

it('list of all software', function () {
    Software::factory()->count(3)->create();

    $response = $this->getJson(route('software.index'));

    $response->assertOk()
    ->assertJsonCount(3);
});

it('create a new software', function () {
    $data = Software::factory()->make()->toArray();

    $response = $this->postJson(route('software.store'), $data);

    $response->assertCreated();
    $response->assertJsonFragment(['name' => $data['name']]);

    $this->assertDatabaseHas('softwares', ['name' => $data['name']]);
});

it('show a specific software', function () {
    $software = Software::factory()->create();

    $response = $this->getJson(route('software.show', ['software' => $software->id]));

    $response->assertOk()
             ->assertJsonFragment(['id' => $software->id]);
});

it('update a software', function () {
    $software = Software::factory()->create();

    $newname = 'Antivirus Pro 2025';
    $response = $this->putJson(route('software.update', ['software' => $software->id]), [
        ...$software->toArray(),
        'name' => $newname,
    ]);

    $response->assertNoContent();
    $this->assertDatabaseHas('softwares', ['name' => $newname]);
});

it('delete a software', function () {
    $software = Software::factory()->create();

    $response = $this->deleteJson(route('software.destroy', ['software' => $software->id]));

    $response->assertNoContent();
    $this->assertDatabaseMissing('softwares', ['id' => $software->id]);
});
