<?php

namespace Database\Factories;

use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Plan>
 */
class PlanFactory extends Factory
{
    protected $model = Plan::class;

    public function definition(): array
    {
        return [
            'numero_plan' => $this->faker->numberBetween(1, 100),
            'nombre' => $this->faker->words(3, true),
            'descripcion' => $this->faker->paragraph,
        ];
    }
}
