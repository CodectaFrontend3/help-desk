<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Software>
 */
class SoftwareFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->word,
            'licencia' => $this->faker->uuid,
            'correo' => $this->faker->unique()->safeEmail,
            'contraseña' => $this->faker->password,
            'proveedor' => $this->faker->company,
            'fecha_instalacion' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'fecha_caducidad' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s')
        ];
    }
}
