<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logged extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $primaryKey = 'login'; 

    protected $fillable = [
        'login', 'date_login', 'sc_session', 'ip'
    ];
}
