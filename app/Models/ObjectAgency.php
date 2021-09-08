<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectAgency extends Model
{
    protected $fillable = [
        'agency'
    ];

    public function objectCodeAgencies()
    {
        return $this->hasMany(ObjectCodeAgency::class, 'object_agency_id', 'id');
    }

}
