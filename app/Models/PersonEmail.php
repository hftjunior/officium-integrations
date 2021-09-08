<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmail extends Model
{
    protected $fillable = [
        'person_id', 'email', 'type'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }
}
