<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Software;
use App\Models\SoftwareMachine;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoftwareMachine>
 */
class SoftwareMachineFactory extends Factory
{
    protected $model = SoftwareMachine::class;
    public function definition(): array
    {
        $software = Software::pluck('id')->toArray();
        $machine = Machine::pluck('id')->toArray();
        return [
            'id_software' => $this->faker->randomElement($software) ?? Software::factory(),
            'id_machine' => $this->faker->randomElement($machine) ?? Machine::factory()
        ];
    }
}
