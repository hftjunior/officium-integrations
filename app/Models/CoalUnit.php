<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalUnit extends Model
{
    protected $fillable = [
        'person_related_id', 'unit', 'state_id', 'city_id', 'latitude',
        'longitude', 'result_center_id', 'oid'
    ];

    public function state()
    {
        return $this->belongsTo(State::class);
    }

    public function city()
    {
        return $this->belongsTo(City::class);
    }

    public function related()
    {
        return $this->belongsTo(PersonRelated::class, 'person_related_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class);
    }

    public function ovens()
    {
        return $this->hasMany(CoalOven::class, 'coal_unit_id', 'id');
    }
}
