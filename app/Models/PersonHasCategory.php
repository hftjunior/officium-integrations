<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonHasCategory extends Model
{
    protected $fillable = [
        'person_id', 'person_category_id'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'person_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(PersonCategory::class, 'person_category_id', 'id');
    }
}
