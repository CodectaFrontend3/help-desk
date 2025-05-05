<?php

namespace Database\Factories;

use App\Models\CuentaTrabajador;
use App\Models\Equipo;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CuentaTrabajador>
 */
class CuentaTrabajadorFactory extends Factory
{
    protected $model = CuentaTrabajador::class;
    public function definition(): array
    {
        return [
            'id_equipos' => Equipo::factory(),
            'nombre_usuario' => $this->faker->userName(),
            'area' => $this->faker->word(),
            'correoT' => $this->faker->unique()->safeEmail(),
            'contraseña' => $this->faker->password(),
            'sucursal' => $this->faker->city(),
        ];
    }
}
