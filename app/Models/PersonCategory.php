<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonCategory extends Model
{
    protected $fillable = [
        'type', 'category'
    ];

    public function persons()
    {
        return $this->belongsToMany(Person::class, 'person_has_categories', 'person_id', 'person_category_id');
    }
}
