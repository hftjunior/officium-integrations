<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmployeeRole extends Model
{
    protected $fillable = [
        'code', 'role',
    ];

    public function employees()
    {
        return $this->hasMany(PersonEmployee::class, 'role_id', 'id');
    }
}
