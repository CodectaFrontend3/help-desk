<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountWorker extends Model
{
    use HasFactory;
    protected $table = 'account_workers';
    protected $fillable =[
        'id_machine','username','area','emailT','password',
        'branch'
    ];
    public function machines(){
        return$this->belongsTo(Machine::class,'id_machine');
    }
}
