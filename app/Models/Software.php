<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;
    protected $table = "software";
    protected $fillable = [
        'nombre','licencia','correo','contraseña','proveedor','fecha_instalacion','fecha_caducidad'
    ];

    public function softwareEquipo(){
        return $this->hasMany(SoftwareEquipo::class,'id_software');
    }
}
