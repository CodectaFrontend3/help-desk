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

    public function softwareTeams(){
        return $this->hasMany(SoftwareTeam::class,'id_software');
    }
}
