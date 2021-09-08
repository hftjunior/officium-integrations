<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectCodeAgency extends Model
{
    protected $fillable = [
        'object_id', 'object_agency_id', 'code'
    ];

    public function object()
    {
        return $this->belongsTo(Object::class, 'object_id', 'id');
    }

    public function objectAgency()
    {
        return $this->hasMany(ObjectAgency::class, 'object_agency_id', 'id');
    }
}
