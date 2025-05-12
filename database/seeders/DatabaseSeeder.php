<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        // User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
        $this->call(ClientGSeeder::class);
        $this->call(PlanSeeder::class);
        $this->call(SoftwareSeeder::class);
        $this->call(RegisterHardwareSeeder::class);
        $this->call(HardwareSeeder::class);
        $this->call(AccountRegisterSeeder::class);
        $this->call(TeamSeeder::class);
        $this->call(AccountWorkerSeeder::class);
        $this->call(SoftwareTeamSeeder::class);
        $this->call(CompanySeeder::class);
        $this->call(BranchSeeder::class);
        $this->call(MicroCompanySeeder::class);
        $this->call(NaturalPersonSeeder::class);
        $this->call(AreaSeeder::class);
        $this->call(ContactRefSeeder::class);
        $this->call(TicketSeeder::class);
    }
}
