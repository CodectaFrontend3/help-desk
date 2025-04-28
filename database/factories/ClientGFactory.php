<?php

namespace Database\Factories;

use App\Models\ClientG;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ClientG>
 */
class ClientGFactory extends Factory
{
    protected $model = ClientG::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->firstName(),
            'last_name' => $this->faker->lastName(),
            'address' => $this->faker->address(),
            'email' => $this->faker->unique()->safeEmail(),
            'phone_number' => $this->faker->phoneNumber(),
            'plan_number' => $this->faker->numberBetween(1, 100),
        ];
    }
}
