<?php

namespace Database\Seeders;

use App\Models\ClientG;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ClientGSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ClientG::factory()->count(20)->create();
    }
}
