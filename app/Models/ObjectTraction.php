<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectTraction extends Model
{
    protected $fillable = [
        'traction'
    ];

    public function objects()
    {
        return $this->hasMany(Objects::class, 'object_traction_id', 'id');
    }
}
