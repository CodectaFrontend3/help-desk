<?php

namespace Database\Factories;

use App\Models\AccountRegister;
use App\Models\ClientG;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\AccountRegister>
 */
class AccountRegisterFactory extends Factory
{
    protected $model = AccountRegister::class;
    public function definition(): array
    {
        return [
            'id_clientG' => ClientG::factory(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => $this->faker->password(8)
        ];
    }
}
