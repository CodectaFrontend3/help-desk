<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    protected $table = 'company'; // Especifica el nombre de la tabla en singular
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
}