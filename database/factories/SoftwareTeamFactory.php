<?php

namespace Database\Factories;

use App\Models\Machine;
use App\Models\Software;
use App\Models\SoftwareTeam;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\SoftwareTeam>
 */
class SoftwareTeamFactory extends Factory
{
    protected $model = SoftwareTeam::class;
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
