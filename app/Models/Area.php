<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
     protected $table = 'area';
     protected $fillable = [
        'nombre_area', 
        'contacto', 
        'telefono', 
        'correo'
    ];
}
