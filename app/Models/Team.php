<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $table = 'teams';

    protected $fillable = [
        'id_clientG','id_company','id_microcompany','id_personN','id_plan','type',
        'brand','username','end_revision','revision_scheduled'
    ];

    public function clientsG(){
        return $this->belongsTo(ClientG::class,'id_clientG');
    }
    public function companies(){
        return $this->belongsTo(Company::class,'id_company');
    }
    public function microCompanies(){
        return $this->belongsTo(MicroCompany::class,'id_microcompany');
    }
    public function naturalPersons(){
        return $this->belongsTo(NaturalPerson::class,'id_personN');
    }
    public function plans(){
        return $this->belongsTo(Plan::class,'id_plan');
    }
    // public function softwareEquipo(){
    //     return $this->hasMany(SoftwareEquipo::class,'id_equipos');
    // }
    // public function cuentaTrabajador(){
    //     return $this->hasOne(CuentaTrabajador::class,'id_equipos');
    // }
}
