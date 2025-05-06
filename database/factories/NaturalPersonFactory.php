<?php

namespace Database\Factories;

use App\Models\NaturalPerson;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\NaturalPerson>
 */
class NaturalPersonFactory extends Factory
{
    protected $model = NaturalPerson::class;
    public function definition(): array
    {
        return [
            'dni' => $this->faker->numerify('###########'),
            'name' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
        ];
    }
}
