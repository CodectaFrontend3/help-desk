<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonalNatural extends Model
{
    protected $table = 'personal_natural';

    protected $fillable = [
        'dni','nombre','telefono','correo'
    ];
}
