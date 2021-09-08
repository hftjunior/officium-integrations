<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectStatus extends Model
{
    protected $fillable = [
        'status'
    ];

    public function objects()
    {
        return $this->hasMany(Objects::class,'object_status_id','id');
    }
}
