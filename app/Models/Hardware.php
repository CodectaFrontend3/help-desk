<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Hardware extends Model
{
    protected $table='hardwares';

    use HasFactory;

    protected $fillable=[
        'id_RH','id_machine','type_team','serial_number','buy_date','plan','brand','supplier',
        'description','end_revision','revision_scheduled',
    ];

    public function registerHardwares(){
        return $this->belongsTo(RegisterHardware::class,'id_RH');
    }
    public function machines(){
        return $this->belongsTo(Machine::class,'id_machine');
    }
}
