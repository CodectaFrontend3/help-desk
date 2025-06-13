<?php

namespace Database\Seeders;

use App\Models\AccountRegister;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AccountRegisterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccountRegister::factory()->count(20)->create();
    }
}
