<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "planes";

    use HasFactory;

    protected $fillable = [
        "numero_plan",
        "nombre",
        "descripcion"
    ];

    public function equipo(){
        return $this->hasMany(Equipo::class,'id_plan');
    }
}
