<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectNoteFuelLocal extends Model
{
    protected $fillable = [
        'local', 'status'
    ];

    public function objectNoteFuelSupply()
    {
        return $this->hasMany(objectNoteFuelSupply::class, 'local_id', 'id');
    }
}
