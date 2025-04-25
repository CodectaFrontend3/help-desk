<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table='hardware';

    use HasFactory;

    protected $fillable=[
        'id_RH','tipo_equipo','num_serie','fecha_compra','plan','marca','proveedor',
        'descripcion','ult_revision','rev_programada',
    ];

    public function registroHardware(){
        return $this->belongsTo(RegistroHardware::class,'id_RH');
    }
}
