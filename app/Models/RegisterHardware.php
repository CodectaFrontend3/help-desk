<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RegisterHardware extends Model
{
    protected $table = "register_hardware";

    use HasFactory;

    protected $fillable =[
        'installation_date','description','serie','supplier'
    ];
}
