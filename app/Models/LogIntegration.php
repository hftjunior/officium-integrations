<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogIntegration extends Model
{
    protected $fillable = [
        'user', 'form', 'code', 'status', 'message'
    ];
}
