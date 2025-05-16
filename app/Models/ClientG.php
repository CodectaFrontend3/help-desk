<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientG extends Model
{
    protected $table = "clients_g";

    use HasFactory;

    protected $fillable = [
        'name','last_name','address','email','phone_number','plan_number',
    ];
    public function AccountRegister()
    {
        return $this->hasOne(AccountRegister::class, 'id_clientG');
    }
    public function machines(){
        return $this->hasMany(Machine::class,'id_clientG');
    }
}

