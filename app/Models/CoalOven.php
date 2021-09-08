<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalOven extends Model
{
    protected $fillable = [
        'coal_unit_id', 'ovens', 'oven_type_id',
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class, 'coal_unit_id', 'id');
    }

    public function ovenType()
    {
        return $this->belongsTo(CoalOvenType::class, 'oven_type_id', 'id');
    }

    public function productions()
    {
        return $this->hasMany(CoalProduction::class, 'coal_oven_id', 'id');
    }
}
