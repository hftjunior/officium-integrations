<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectModel extends Model
{
    protected $fillable = [
        'manufacture_id', 'model'
    ];

    public function objectManufacture()
    {
        return $this->belongsTo(ObjectManufacture::class, 'manufacture_id', 'id');
    }

    public function objects()
    {
        return $this->hasMany(Objects::class, 'object_model_id', 'id');
    }
}
