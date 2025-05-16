<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NaturalPerson extends Model
{   
    use HasFactory;
    protected $table = 'natural_persons';
    protected $fillable = [
        "name",
        "dni",
        "phone",
        "email",
    ];
    public function machines(){
        return $this->hasMany(Machine::class,'id_personN');
    }
}