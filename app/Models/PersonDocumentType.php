<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonDocumentType extends Model
{
    protected $fillable = [
        'type'
    ];

    public function documents()
    {
        return $this->hasMany(PersonDocument::class, 'document_type_id', 'id');
    }
}
