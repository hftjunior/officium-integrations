<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalDcf extends Model
{
    protected $fillable = [
        'coal_unit_id', 'number', 'dtemission', 'volwood',
        'volcharcoal', 'dae', 'process', 'file', 'active'
    ];

    public function coalUnit()
    {
        return $this->belongsTo(CoalUnit::class);
    }

    public function dcfLocations()
    {
        return $this->hasMany(CoalDcfLocation::class, 'coal_dcf_id', 'id');
    }

}
