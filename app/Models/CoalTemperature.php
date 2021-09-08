<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalTemperature extends Model
{
    protected $fillable = [
        'coal_production_step_id', 'coal_unit_id', 'coal_oven_id',
        'coal_temperature_point_id', 'dtcollection', 'temperature',
        'status', 'round', 'notes'
    ];

    public function step()
    {
        return $this->belongsTo(CoalStep::class);
    }

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }

    public function oven()
    {
        return $this->belongsTo(CoalOven::class);
    }

    public function temperaturePoint()
    {
        return $this->belongsTo(CoalTemperaturePoint::class);
    }
}
