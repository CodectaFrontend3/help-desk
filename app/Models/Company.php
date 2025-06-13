<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Factories\HasFactory; // Permite crear factories para modelos

class Company extends Model
{
    use HasFactory; // Permite crear factories para modelos
    protected $fillable = [
        "client_name",
        "ruc",
        "address",
        "phone",
        "email",
    ];

    /**
     * Get the branches for the company.
     */
    public function branches(): HasMany
    {
        return $this->hasMany(Branch::class);
    }
    public function machines()
    {
        return $this->hasMany(Machine::class,'id_company');
    }
}
