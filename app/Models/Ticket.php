<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;
    protected $table = 'tickets';
    protected $fillable = [
        'machine_id',
        'incident_type',
        'client_name',
        'company',
        'area',
        'branch',
        'state',
        'registration_date',
    ];

    public function machines()
    {
        return $this->belongsTo(Machine::class,'machine_id');
    }
    
}
