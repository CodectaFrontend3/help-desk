<?php

namespace Database\Seeders;

use App\Models\RegisterHardware;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RegisterHardwareSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RegisterHardware::factory()->count(20)->create();
    }
}
