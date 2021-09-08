<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalPayment extends Model
{
    protected $fillable = [
        'payment', 'code_erp'
    ];
}
