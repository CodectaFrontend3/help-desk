<?php

namespace Database\Seeders;

use App\Models\SoftwareTeam;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SoftwareTeamSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        SoftwareTeam::factory()->count(20)->create();
    }
}
