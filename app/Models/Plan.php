<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "plan";

    use HasFactory;

    protected $fillable = [
        "plan_number",
        "name",
        "description"
    ];

    // public function equipo(){
    //     return $this->hasMany(Equipo::class,'id_plan');
    // }
}
