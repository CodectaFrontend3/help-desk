<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClienteG extends Model
{
    protected $table = "cliente_g";

    protected $fillable = [
        'nombre','apellido','direccion','correo','num_telefono','numero_plan',
    ];
}
