<?php

namespace Database\Factories;

use App\Models\ClientG;
use App\Models\Company;
use App\Models\MicroCompany;
use App\Models\NaturalPerson;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Machine>
 */
class MachineFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $clientG = ClientG::pluck('id')->toArray();
        $company = Company::pluck('id')->toArray();
        $naturalPerson = NaturalPerson::pluck('id')->toArray();
        $plan = Plan::pluck('id')->toArray();
        
        return [
            'id_clientG' => $this->faker->randomElement($clientG) ?? ClientG::factory(),
            'id_company' => $this->faker->randomElement($company) ?? Company::factory(),
            'id_personN' => $this->faker->randomElement($naturalPerson) ?? NaturalPerson::factory(),
            'id_plan' => $this->faker->randomElement($plan) ?? Plan::factory(),
            'type' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'username' => $this->faker->userName(),
            'end_revision' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'revision_scheduled' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s')
        ];
    }
}
