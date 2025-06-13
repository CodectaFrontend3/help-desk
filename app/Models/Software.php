<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Software extends Model
{
    use HasFactory;
    protected $table = "softwares";
    protected $fillable = [
        'name','license','email','password','supplier','installation_date','expiration_date'
    ];

    public function softwareMachines(){
        return $this->hasMany(SoftwareMachine::class,'id_software');
    }
}
