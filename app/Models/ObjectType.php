<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectType extends Model
{
    protected $fillable = [
        'type'. 'implement'
    ];

    public function objects()
    {
        return $this->hasMany(Object::class, 'object_type_id', 'id');
    }
}
