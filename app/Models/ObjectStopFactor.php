<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectStopFactor extends Model
{
    protected $fillable = [
        'code','factor','type_id'
    ];

    public function type()
    {
        return $this->belongsTo(ObjectStopFactorType::class, 'type_id', 'id');
    }    
}
