<?php

namespace Database\Factories;

use App\Models\ClienteG;
use App\Models\Empresa;
use App\Models\Equipo;
use App\Models\MicroEmpresa;
use App\Models\PersonaNatural;
use App\Models\Plan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Equipo>
 */
class EquipoFactory extends Factory
{
    protected $model = Equipo::class;
    public function definition(): array
    {
        return [
            'id_clienteG' => ClienteG::factory(),
            'id_empresa' => Empresa::factory(),
            'id_microempresa' => MicroEmpresa::factory(),
            'id_personaN' => PersonaNatural::factory(),
            'id_plan' => Plan::factory(),
            'tipo' => $this->faker->word(),
            'marca' => $this->faker->company(),
            'nombre_usuario' => $this->faker->userName(),
            'ult_revision' => $this->faker->dateTimeBetween('-1 year', 'now')->format('Y-m-d H:i:s'),
            'revision_programada' => $this->faker->dateTimeBetween('now', '+1 year')->format('Y-m-d H:i:s')
        ];
    }
}
