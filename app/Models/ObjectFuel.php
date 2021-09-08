<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectFuel extends Model
{
    protected $fillable = [
        'fuel'
    ];

    public function objects()
    {
        return $this->hasMany(Objects::class, 'object_fuel_id', 'id');
    }
}
