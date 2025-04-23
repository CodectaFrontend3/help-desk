<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MicroEmpresa extends Model
{
    protected $table = 'micro_empresas';
    protected $fillable = [
        'nombre_cliente', 
        'ruc', 
        'direccion', 
        'telefono', 
        'correo'
    ];
}
