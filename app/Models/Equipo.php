<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Equipo extends Model
{
    use HasFactory;

    protected $table = 'equipo';

    protected $fillable = [
        'id_clienteG','id_empresa','id_microempresa','id_personaN','id_plan','tipo',
        'marca','nombre_usuario','ult_revision','revision_programada'
    ];

    public function clienteG(){
        return $this->belongsTo(ClienteG::class,'id_clienteG');
    }
    public function empresa(){
        return $this->belongsTo(ClienteG::class,'id_empresa');
    }
    public function microEmpresa(){
        return $this->belongsTo(ClienteG::class,'id_microempresa');
    }
    public function personaNatural(){
        return $this->belongsTo(ClienteG::class,'id_personaN');
    }
    public function plan(){
        return $this->belongsTo(ClienteG::class,'id_plan');
    }
    public function softwareEquipo(){
        return $this->hasMany(SoftwareEquipo::class,'id_equipos');
    }
}
