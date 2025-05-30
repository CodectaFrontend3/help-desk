<?php

namespace Database\Factories;

use App\Models\ContactRef;
use App\Models\Company;
use App\Models\NaturalPerson;
use App\Models\Area;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\ContactRef>
 */
class ContactRefFactory extends Factory
{
    
    protected $model = ContactRef::class;
    public function definition(): array
    {
        return [
            'company_id' => Company::exists() ? Company::pluck('id')->random() : Company::factory()->create()->id,  
            'natural_person_id' => NaturalPerson::exists() ? NaturalPerson::pluck('id')->random() : NaturalPerson::factory()->create()->id, 
            'area_id' => Area::exists() ? Area::pluck('id')->random() : Area::factory()->create()->id,
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'manager' => $this->faker->name(),
        ];
    }
}
