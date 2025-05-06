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
        return [
            'id_software' => Software::factory(),
            'id_team' => Team::factory()
        ];
    }
}
