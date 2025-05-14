<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MicroCompany extends Model
{   
    use HasFactory;
    protected $table = 'micro_companies';
    protected $fillable = [
        "client_name",
        "ruc",
        "address",
        "phone",
        "email",
    ];
    public function machines()
    {
        return $this->hasMany(Machine::class,'id_microcompany');
    }
}