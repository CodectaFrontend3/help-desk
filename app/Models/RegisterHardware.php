<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterHardware extends Model
{
    protected $table = "register_hardwares";

    use HasFactory;

    protected $fillable =[
        'installation_date','description','serie','supplier'
    ];
    public function hardwares(){
        return $this->hasMany(Hardware::class,'id_RH');
    }
}
