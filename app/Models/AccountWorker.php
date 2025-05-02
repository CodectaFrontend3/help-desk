<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountWorker extends Model
{
    use HasFactory;
    protected $table = 'account_workers';
    protected $fillable =[
        'id_team','username','area','emailT','password',
        'branch'
    ];
    public function teams(){
        return$this->belongsTo(Equipo::class,'id_team');
    }
}
