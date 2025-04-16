<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RegistroCuenta extends Model
{
    protected $table ='registro_cuentas';

    protected $fillable = [
        'id_clienteG','correo','contraseña',
    ];
}
