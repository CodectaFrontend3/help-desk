<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CuentaTrabajador extends Model
{
    use HasFactory;
    protected $table = 'cuenta_trabajador';
    protected $fillable =[
        'id_equipos','nombre_usuario','area','correoT','contraseña',
        'sucursal'
    ];
    public function equipo(){
        return$this->belongsTo(Equipo::class,'id_equipos');
    }
}
