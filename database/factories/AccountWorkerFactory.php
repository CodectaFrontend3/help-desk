<?php

namespace Database\Factories;

use App\Models\AccountWorker;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountWorker>
 */
class AccountWorkerFactory extends Factory
{
    protected $model = AccountWorker::class;
    public function definition(): array
    {
        return [
            'id_team' => Team::factory(),
            'username' => $this->faker->userName(),
            'area' => $this->faker->word(),
            'emailT' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(),
            'branch' => $this->faker->city()
        
        ];
    }
}
