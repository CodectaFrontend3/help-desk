<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipo';

    protected $fillable = [
        'id_clienteG','id_empresa','id_microempresa','id_personaN','id_plan','tipo',
        'marca','nombre_usuario','ult_revision','revision_programada'
    ];
}
