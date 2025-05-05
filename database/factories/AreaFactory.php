<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Company;
use App\Models\MicroCompany;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition(): array
    {
        return [
            'micro_company_id' => MicroCompany::factory(),
            'company_id'       => Company::factory(),
            'branch_id'        => Branch::factory(),
            'area_name'        => $this->faker->word(),
            'contact'          => $this->faker->name(),
            'phone'            => $this->faker->numerify('9########'),
            'email'            => $this->faker->unique()->safeEmail(),
        ];
    }
}
