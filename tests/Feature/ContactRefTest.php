<?php

use App\Models\ContactRef;
use App\Models\Company;
use App\Models\NaturalPerson;
use App\Models\Area;
use Illuminate\Foundation\Testing\RefreshDatabase;

uses(RefreshDatabase::class);
beforeEach(function () {$this->setTestUserWithPermissions("ContactRef");});

// Test: crear un contacto
it('create a contact', function () {
    $company = Company::factory()->create();
    $naturalPerson = NaturalPerson::factory()->create();
    $area = Area::factory()->create();

    $response = $this->postJson('/api/contact_refs', [
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
        'name' => 'Juan Pérez',
        'address' => 'Calle Ficticia 123',
        'email' => 'juan@empresa.com',
        'phone' => '987654321',
        'manager' => 'Carlos García',
    ]);

    $response->assertStatus(201)
             ->assertJsonFragment([
                 'name' => 'Juan Pérez',
                 'address' => 'Calle Ficticia 123',
             ]);

    expect(ContactRef::count())->toBe(1);
});

// Test: listar todos los contactos
it('list all contacts', function () {
    $company = Company::factory()->create();
    $naturalPerson = NaturalPerson::factory()->create();
    $area = Area::factory()->create();

    ContactRef::factory()->count(3)->create([
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
    ]);

    $response = $this->getJson('/api/contact_refs');

    $response->assertStatus(200)
             ->assertJsonCount(3);
});

// Test: ver un contacto específico
it('show a contact specific', function () {
    $company = Company::factory()->create();
    $naturalPerson = NaturalPerson::factory()->create();
    $area = Area::factory()->create();
    $contactRef = ContactRef::factory()->create([
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
    ]);

    $response = $this->getJson("/api/contact_refs/{$contactRef->id}");

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'id' => $contactRef->id,
                 'name' => $contactRef->name,
             ]);
});

// Test: actualizar un contacto
it('update a contact', function () {
    $company = Company::factory()->create();
    $naturalPerson = NaturalPerson::factory()->create();
    $area = Area::factory()->create();
    $contactRef = ContactRef::factory()->create([
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
    ]);

    $response = $this->putJson("/api/contact_refs/{$contactRef->id}", [
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
        'name' => 'Carlos López',
        'address' => 'Calle Actualizada 456',
        'email' => 'carlos@empresa.com',
        'phone' => '912345678',
        'manager' => 'Ana López',
    ]);

    $response->assertStatus(200)
             ->assertJsonFragment([
                 'name' => 'Carlos López',
                 'address' => 'Calle Actualizada 456',
             ]);
});

// Test: eliminar un contacto
it('delete a contact', function () {
    $company = Company::factory()->create();
    $naturalPerson = NaturalPerson::factory()->create();
    $area = Area::factory()->create();
    $contactRef = ContactRef::factory()->create([
        'company_id' => $company->id,
        'natural_person_id' => $naturalPerson->id,
        'area_id' => $area->id,
    ]);

    $response = $this->deleteJson("/api/contact_refs/{$contactRef->id}");

    $response->assertNoContent();
    expect(ContactRef::count())->toBe(0);
});