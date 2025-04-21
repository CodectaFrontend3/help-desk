<?php

namespace Database\Factories;

use App\Models\ClienteG;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClienteG>
 */
class ClienteGFactory extends Factory
{
    protected $model = ClienteG::class;
    
    public function definition(): array
    {
        return [
            'nombre' => $this->faker->firstName(),
            'apellido' => $this->faker->lastName(),
            'direccion' => $this->faker->address(),
            'correo' => $this->faker->unique()->safeEmail(),
            'num_telefono' => $this->faker->phoneNumber(),
            'numero_plan' => $this->faker->numberBetween(1, 100),
        ];
    }
}
