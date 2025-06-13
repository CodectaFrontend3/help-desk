<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactRef extends Model
{   
    use HasFactory;
    protected $table = 'contact_refs';
    protected $fillable = [
        'company_id',
        'natural_person_id',
        'area_id',
        'name',
        'address',
        'email',
        'phone',
        'manager',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function naturalPerson()
    {
        return $this->belongsTo(NaturalPerson::class);
    }

    public function area()
    {
        return $this->belongsTo(Area::class);
    }

}
