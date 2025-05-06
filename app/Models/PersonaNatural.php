<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PersonaNatural extends Model
{
    use HasFactory;
    protected $table = 'persona_natural';
    protected $fillable = [
        'dni', 
        'nombre', 
        'telefono', 
        'correo'
    ];
    public function equipo(){
        return $this->hasMany(Equipo::class,'id_personaN');
    }
}
