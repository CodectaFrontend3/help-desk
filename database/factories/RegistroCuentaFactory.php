<?php

namespace Database\Factories;

use App\Models\ClienteG;
use App\Models\RegistroCuenta;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegistroCuenta>
 */
class RegistroCuentaFactory extends Factory
{
    protected $model = RegistroCuenta::class;

    public function definition(): array
    {
        return [
            'id_clienteG' => ClienteG::factory(),
            'correo' => $this->faker->unique()->safeEmail(),
            'contraseña' => $this->faker->password(8),
        ];
    }
}
