<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmployeePayment extends Model
{
    protected $fillable = [
        'payment'
    ];

    public function employees()
    {
        return $this->hasMany(PersonEmployee::class, 'payment_id', 'id');
    }
}
