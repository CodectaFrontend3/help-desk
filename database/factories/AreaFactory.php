<?php

namespace Database\Factories;

use App\Models\Area;
use App\Models\Branch;
use App\Models\Company;
use Illuminate\Database\Eloquent\Factories\Factory;

class AreaFactory extends Factory
{
    protected $model = Area::class;

    public function definition(): array
    {
        return [
            'company_id' => Company::exists() ? Company::pluck('id')->random() : Company::factory()->create()->id,
            'branch_id' => Branch::exists() ? Branch::pluck('id')->random() : Branch::factory()->create()->id,
            'area_name'        => $this->faker->word(),
            'contact'          => $this->faker->name(),
            'phone'            => $this->faker->numerify('9########'),
            'email'            => $this->faker->unique()->safeEmail(),
        ];
    }
}
