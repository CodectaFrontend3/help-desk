<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroCuenta extends Model
{
    protected $table ='registro_cuentas';

    use HasFactory;

    protected $fillable = [
        'id_clienteG','correo','contraseña',
    ];
    public function clienteG()
    {
        return $this->belongsTo(clienteG::class, 'id_clienteG');
    }
}
