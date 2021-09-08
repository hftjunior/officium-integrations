<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonDocumentFrequency extends Model
{
    protected $fillable = [
        'frequency', 'days', 'day'
    ];

    public function personDocuments()
    {
        return $this->hasMany(PersonDocument::class, 'person_document_frequency_id', 'id');
    }
}
