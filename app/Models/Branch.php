<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Branch extends Model
{
    protected $table = 'branch'; // Especifica el nombre de la tabla en singular
    protected $fillable = [
        "company_id",
        "branch_name",
        "manager",
        "phone",
        "email",
    ];

    /**
     * Get the company that owns the branch.
     */
    public function company(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
