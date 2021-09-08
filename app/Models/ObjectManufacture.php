<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectManufacture extends Model
{
    protected $fillable = [
        'manufacture'
    ];

    public function objectModels()
    {
        return $this->hasMany(ObjectModel::class, 'manufacture_id', 'id');
    }

    public function objects()
    {
        return $this->hasMany(Objects::class, 'object_manufacture_id', 'id');
    }
}
