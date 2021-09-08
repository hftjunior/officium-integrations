<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntRegion extends Model
{
    protected $fillable = [
        'region', 'sgf_id'
    ];

    public function locations()
    {
        return $this->hasMany(IntLocation::class, 'int_region_id', 'id');
    }
}
