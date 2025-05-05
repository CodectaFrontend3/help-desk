<?php

namespace Database\Factories;

use App\Models\ContactRef;
use App\Models\Company;
use App\Models\MicroCompany;
use App\Models\NaturalPerson;
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
            'company_id' => Company::factory(),  
            'micro_company_id' => MicroCompany::factory(),  
            'natural_person_id' => NaturalPerson::factory(), 
            'name' => $this->faker->name(),
            'address' => $this->faker->address(),
            'email' => $this->faker->email(),
            'phone' => $this->faker->phoneNumber(),
            'manager' => $this->faker->name(),
        ];
    }
}
