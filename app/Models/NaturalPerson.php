<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class NaturalPerson extends Model
{
    protected $fillable = [
        "name",
        "dni",
        "phone",
        "email",
    ];
}