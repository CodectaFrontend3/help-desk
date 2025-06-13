<?php

namespace Database\Seeders;

use App\Models\AccountWorker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountWorkerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountWorker::factory()->count(20)->create();
    }
}
