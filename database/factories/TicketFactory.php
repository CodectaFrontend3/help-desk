<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\Team;
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
            'team_id' => Team::factory(),
            'incident_type' => $this->faker->randomElement(['Red', 'Network', 'Hardware', 'Software']),
            'client_name' => $this->faker->name(),
            'company' => $this->faker->company(),
            'area' => $this->faker->word(),
            'branch' => $this->faker->city(),
            'state' => $this->faker->randomElement(['Abierto', 'En Proceso', 'Cerrado']),
            'registration_date' => $this->faker->date(),
        ];
    }
}
