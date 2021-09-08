<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalProduction extends Model
{
    protected $fillable = [
        'coal_unit_id', 'coal_oven_id', 'round',
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }

    public function oven()
    {
        return $this->belongsTo(CoalOven::class);
    }

    public function productionSteps()
    {
        return $this->hasMany(CoalProductionSteps::class, 'coal_production_id', 'id');
    }
}
