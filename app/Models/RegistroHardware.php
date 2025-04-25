<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegistroHardware extends Model
{
    protected $table = "registro_hardware";

    use HasFactory;

    protected $fillable =[
        'fecha_instalacion','descripcion','serie','proveedor'
    ];
    public function hardware(){
        return $this->hasMany(Hardware::class,'id_RH');
    }
}
