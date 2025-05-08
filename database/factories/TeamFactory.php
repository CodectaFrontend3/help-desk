<?php

namespace Database\Factories;

use App\Models\ClientG;
use App\Models\Company;
use App\Models\MicroCompany;
use App\Models\NaturalPerson;
use App\Models\Plan;
use App\Models\Team;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Team>
 */
class TeamFactory extends Factory
{
    protected $model = Team::class;
    public function definition(): array
    {
        $clientG = ClientG::pluck('id')->toArray();
        $company = Company::pluck('id')->toArray();
        $microCompany = MicroCompany::pluck('id')->toArray();
        $naturalPerson = NaturalPerson::pluck('id')->toArray();
        $plan = Plan::pluck('id')->toArray();
        
        return [
            'id_clientG' => $this->faker->randomElement($clientG) ?? ClientG::factory(),
            'id_company' => $this->faker->randomElement($company) ?? Company::factory(),
            'id_microcompany' => $this->faker->randomElement($microCompany) ?? MicroCompany::factory(),
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
