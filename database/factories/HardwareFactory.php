<?php

namespace Database\Factories;

use App\Models\Hardware;
use App\Models\Machine;
use App\Models\RegisterHardware;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Hardware>
 */
class HardwareFactory extends Factory
{
    protected $model = Hardware::class;

    public function definition(): array
    {
        $registerHardware = RegisterHardware::pluck('id')->toArray();
        $machine = Machine::pluck('id')->toArray();
        return [
            'id_RH' => $this->faker->randomElement($registerHardware) ?? RegisterHardware::factory(),
            'id_machine' => $this->faker->randomElement($machine) ?? Machine::factory(),
            'type_team' => $this->faker->word(),
            'serial_number' => $this->faker->randomNumber(6),
            'buy_date' => $this->faker->dateTime()->format('Y-m-d H:i:s'),
            'plan' => $this->faker->word(),
            'brand' => $this->faker->company(),
            'supplier' => $this->faker->company(),
            'description' => $this->faker->paragraph(),
            'end_revision' => $this->faker->date('Y-m-d'),
            'revision_scheduled' => $this->faker->date('Y-m-d')
        ];
    }
}
