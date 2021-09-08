<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonProvider extends Model
{
    protected $fillable = [
        'people_id', 'owner_id', 'status'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'people_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Person::class, 'owner_id', 'id');
    }
}
