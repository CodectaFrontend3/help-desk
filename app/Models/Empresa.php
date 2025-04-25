<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    use HasFactory;
    protected $table = 'empresa';
    protected $fillable = [
        'nombre_cliente', 
        'ruc', 
        'direccion', 
        'telefono', 
        'correo'
    ];
    public function equipo(){
        return $this->hasMany(Equipo::class,'id_empresa');
    }
}
