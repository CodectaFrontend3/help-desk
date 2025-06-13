<?php

namespace Database\Factories;

use App\Models\RegisterHardware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\RegisterHardware>
 */
class RegisterHardwareFactory extends Factory
{
    protected $model = RegisterHardware::class;
    public function definition(): array
    {
        return [
            'installation_date' => $this->faker->dateTime->format('Y-m-d H:i:s'),
            'description' => $this->faker->paragraph,
            'serie' => $this->faker->unique()->bothify('SERIE-####'),
            'supplier' => $this->faker->company
        ];
    }
}
