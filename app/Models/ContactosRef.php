<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactosRef extends Model
{
    protected $table = 'contactos_refs';

    protected $fillable = [
        'empresa_id', 
        'microempresa_id', 
        'persona_natural_id', 
        'nombre', 
        'direccion', 
        'correo', 
        'telefono', 
        'cargo'];
}
