<?php

namespace Database\Factories;

use App\Models\RegistroHardware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegistroHardware>
 */
class RegistroHardwareFactory extends Factory
{
    protected $model = RegistroHardware::class;
    public function definition(): array
    {
        return [
            'fecha_instalacion' => $this->faker->dateTime->format('Y-m-d H:i:s'),
            'descripcion' => $this->faker->paragraph,
            'serie' => $this->faker->unique()->bothify('SERIE-####'),
            'proveedor' => $this->faker->company
        ];
    }
}
