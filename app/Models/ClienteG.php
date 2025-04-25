<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClienteG extends Model
{
    protected $table = "cliente_g";

    use HasFactory;

    protected $fillable = [
        'nombre','apellido','direccion','correo','num_telefono','numero_plan',
    ];
    public function registroCuenta()
    {
        return $this->hasOne(RegistroCuenta::class, 'id_clienteG');
    }
    public function equipo(){
        return $this->hasMany(Equipo::class,'id_clienteG');
    }
}
