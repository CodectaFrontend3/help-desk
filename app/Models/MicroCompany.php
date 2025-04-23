<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MicroCompany extends Model
{
    protected $fillable = [
        "name",
        "ruc",
        "address",
        "phone",
        "email",
    ];
}