<?php

namespace Database\Factories;

use App\Models\Equipo;
use App\Models\Software;
use App\Models\SoftwareEquipo;
use Illuminate\Database\Eloquent\Factories\Factory;


class SoftwareEquipoFactory extends Factory
{
    protected $model = SoftwareEquipo::class;
    public function definition(): array
    {
        return [
            'id_software' => Software::factory(),
            'id_equipos' => Equipo::factory()
        ];
    }
}
