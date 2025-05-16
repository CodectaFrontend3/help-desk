<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Machine extends Model
{
    use HasFactory;

    protected $table = 'machines';

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

    public function naturalPersons(){
        return $this->belongsTo(NaturalPerson::class,'id_personN');
    }
    public function plans(){
        return $this->belongsTo(Plan::class,'id_plan');
    }
    public function softwareMachines(){
        return $this->hasMany(SoftwareMachine::class,'id_machine');
    }
    public function accountWorkers(){
        return $this->hasOne(AccountWorker::class,'id_machine');
    }
    public function hardwares(){
        return $this->hasMany(Hardware::class,'id_machine');
    }
}
