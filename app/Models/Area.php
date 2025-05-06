<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Area extends Model
{   
    use HasFactory;

    protected $table = 'areas';

    protected $fillable = [
        'micro_company_id',
        'company_id',
        'branch_id',
        'area_name',
        'contact',
        'phone',
        'email',
    ];

    public function branch()
    {
        return $this->belongsTo(Branch::class); // usa 'branch_id'
    }

    public function microCompany()
    {
        return $this->belongsTo(MicroCompany::class); // usa 'micro_company_id'
    }

    public function company()
    {
        return $this->belongsTo(Company::class); // usa 'company_id'
    }
}

