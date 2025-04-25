<?php

namespace Database\Factories;

use App\Models\Hardware;
use App\Models\RegistroHardware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hardware>
 */
class HardwareFactory extends Factory
{
    protected $model = Hardware::class;

    public function definition(): array
    {
        return [
            'id_RH' => RegistroHardware::factory(),
            'tipo_equipo' => $this->faker->word(),
            'num_serie' => $this->faker->randomNumber(6),
            'fecha_compra' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'plan' => $this->faker->word(),
            'marca' => $this->faker->company(),
            'proveedor' => $this->faker->company(),
            'descripcion' => $this->faker->paragraph(),
            'ult_revision' => $this->faker->date('Y-m-d'),
            'rev_programada' => $this->faker->date('Y-m-d')
        ];
    }
}
