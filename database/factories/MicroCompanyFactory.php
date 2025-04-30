<?php

namespace Database\Factories;

use App\Models\MicroCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\MicroCompany>
 */
class MicroCompanyFactory extends Factory
{
    protected $model = MicroCompany::class;
    public function definition(): array
    {
        return [
            'client_name' => $this->faker->name(),
            'ruc' => $this->faker->numerify('###########'),
            'address' => $this->faker->address,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
