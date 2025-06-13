<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountRegister extends Model
{
    protected $table ='accounts_register';

    use HasFactory;

    protected $fillable = [
        'id_clientG','email','password',
    ];
    public function clientG()
    {
        return $this->belongsTo(clientG::class, 'id_clientG');
    }
}
