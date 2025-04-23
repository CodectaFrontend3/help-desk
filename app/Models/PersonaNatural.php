<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonaNatural extends Model
{
    protected $table = 'persona_natural';
    protected $fillable = [
        'dni', 
        'nombre', 
        'telefono', 
        'correo'
    ];
}
