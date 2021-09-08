<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmployeeShift extends Model
{
    protected $fillable = [
        'shift', 'input', 'output', 'interval', 'weekhours'
    ];

    public function employees()
    {
        return $this->hasMany(PersonEmployee::class, 'shift_id', 'id');
    }
}
