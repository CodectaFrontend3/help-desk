<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoftwareEquipo extends Model
{
    use HasFactory;
    protected $table = 'software_equipo';
    protected $fillable = [
        'id_software','id_equipos'
    ];
    public function software(){
        return $this->belongsTo(Software::class,'id_software');
    }
    public function equipo(){
        return $this->belongsTo(Equipo::class,'id_equipos');
    }
}
