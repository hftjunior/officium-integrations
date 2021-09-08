<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonPhone extends Model
{
    protected $fillable = [
        'person_id', 'phone', 'type'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }
}
