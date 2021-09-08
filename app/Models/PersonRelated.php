<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonRelated extends Model
{
    protected $fillable = [
        'people_id', 'cnpj', 'erp_code'
    ];

    public function person()
    {
        return $this->belongsTo(Person::class, 'people_id', 'id');
    } 
}
