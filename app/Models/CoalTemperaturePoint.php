<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalTemperaturePoint extends Model
{
    protected $fillable = [
        'coal_unit_id', 'point',
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }
}
