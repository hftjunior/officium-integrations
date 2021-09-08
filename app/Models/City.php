<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    protected $fillable = [
        'state_id', 'code', 'city', 'initial',
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function personAdrresses()
    {
        return $this->hasMany(PersonAddress::class);
    }
}
