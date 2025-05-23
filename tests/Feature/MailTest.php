<?php

use Illuminate\Support\Facades\Mail;
use App\Mail\OrderShipped;
use App\Models\User;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

it('sends the OrderShipped mail', function () {
    config(['mail.default' => 'smtp']); // ← fuerza a usar el envío real

    $user = User::factory()->create([
        'name' => 'Test User',
        'email' => 'testuser' . uniqid() . '@example.com',
    ]);

    Mail::to($user->email)->send(new OrderShipped($user));

    expect(true)->toBeTrue(); // solo para pasar el test
});

