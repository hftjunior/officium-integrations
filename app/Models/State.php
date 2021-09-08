<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class State extends Model
{
    protected $fillable = [
        'code', 'state', 'initial',
    ];

    public function cities()
    {
        return $this->hasMany(City::class, 'state_id', 'id');
    }

    public function personAdrresses()
    {
        return $this->hasMany(PersonAddress::class, 'state_id', 'id');
    }

    public function personEmployees()
    {
        return $this->hasMany(PersonEmployee::class, 'state_id', 'id');
    }
}
