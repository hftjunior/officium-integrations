<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonDocument extends Model
{
    protected $fillable = [
        'people_id', 'document_type_id', 'code','category', 'agency',
        'dtemission', 'dtvalidate', 'person_document_frequency_id'
    ];

    public function documentType()
    {
        return $this->belongsTo(PersonDocumentType::class, 'document_type_id', 'id');
    }    
    
    public function person()
    {
        return $this->belongsTo(PersonDocumentType::class, 'document_type_id', 'id');
    }

    public function personDocumentFrequency()
    {
        return $this->belongsTo(PersonDocumentFrequency::class, 'person_document_frequency_id', 'id');
    }    
    
}
