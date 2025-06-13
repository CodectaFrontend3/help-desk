<?php

namespace Database\Factories;

use App\Models\Machine;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Ticket;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Ticket>
 */
class TicketFactory extends Factory
{
    
    protected $model = Ticket::class;
    public function definition(): array
    {
        return [
            'machine_id' => Machine::exists() ? Machine::pluck('id')->random() : Machine::factory()->create()->id,
            'incident_type' => $this->faker->randomElement(['Red', 'Network', 'Hardware', 'Software']),
            'client_name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'area' => $this->faker->word(),
            'branch' => $this->faker->city(),
            'state' => $this->faker->randomElement(['Abierto', 'En Proceso', 'Cerrado']),
            'is_supervised'=> $this->faker->boolean,
            'registration_date' => $this->faker->date(),
        ];
    }
}
