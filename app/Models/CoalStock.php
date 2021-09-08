<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalStock extends Model
{
    protected $fillable = [
        'coal_unit_id', 'type', 'description'
    ];

    public function unit()
    {
        return $this->belongsTo(CoalUnit::class);
    }
}
