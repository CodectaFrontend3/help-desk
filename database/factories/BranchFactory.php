<?php

namespace Database\Factories;
use App\Models\Branch;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Company;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Branch>
 */
class BranchFactory extends Factory
{
    protected $model = Branch::class;
    public function definition(): array
    {
        return [
            'company_id' => Company::exists() ? Company::pluck('id')->random() : Company::factory()->create()->id,
            'branch_name' => $this->faker->name,
            'manager' => $this->faker->name,
            'phone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
        ];
    }
}
