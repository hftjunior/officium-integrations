<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonAddress extends Model
{
    protected $fillable = [
        'person_id', 'street_type_id', 'street', 'number', 'complement', 'neighborhood', 'state_id',
        'city_id', 'cep', 'type', 'direct'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function streetType()
    {
        return $this->belongsTo(StreetType::class, 'street_type_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function city()
    {
        return $this->belongsTo(City::class, 'city_id', 'id');
    }
}
