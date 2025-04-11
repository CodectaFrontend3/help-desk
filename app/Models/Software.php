<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    protected $table = "software";
    protected $fillable = [
        'nombre','licencia','correo','contraseña','proveedor','fecha_instalacion','fecha_caducidad'
    ];
}
