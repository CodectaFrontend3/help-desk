<?php

namespace Database\Factories;

use App\Models\Software;
use App\Models\SoftwareTeam;
use App\Models\Team;
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
        $team = Team::pluck('id')->toArray();
        return [
            'id_software' => $this->faker->randomElement($software) ?? Software::factory(),
            'id_team' => $this->faker->randomElement($team) ?? Team::factory()
        ];
    }
}
