<?php

namespace Database\Factories;

use App\Models\Software;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Software>
 */
class SoftwareFactory extends Factory
{
    protected $model = Software::class;
    public function definition(): array
    {
        return [
            'name' => $this->faker->word(),
            'license' => $this->faker->uuid(),
            'email' => $this->faker->safeEmail(),
            'password' => $this->faker->password(),
            'supplier' => $this->faker->company(),
            'installation_date' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'expiration_date' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s')
        ];
    }
}
