<?php

namespace Database\Factories;

use App\Models\PersonaNatural;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PersonaNatural>
 */
class PersonaNaturalFactory extends Factory
{
    protected $model = PersonaNatural::class;
    public function definition(): array
    {
        return [
            'dni' => $this->faker->unique()->numerify('########'),
            'nombre' => $this->faker->name,
            'telefono' => $this->faker->phoneNumber,
            'correo' => $this->faker->unique()->safeEmail,
        ];
    }
}
