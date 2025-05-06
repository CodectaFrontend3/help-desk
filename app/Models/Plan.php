<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    protected $table = "plans";

    use HasFactory;

    protected $fillable = [
        "plan_number",
        "name",
        "description"
    ];

    public function teams(){
        return $this->hasMany(Team::class,'id_plan');
    }
}
