<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractDocument extends Model
{
    protected $fillable = [
        'contract_employee_id', 'person_document_type_id',
        'dtpendency', 'dtdelivery'
    ];

    public function contractEmployee()
    {
        return $this->belongsTo(ContractEmployee::class, 'contract_employee_id', 'id');
    }

    public function personDocumentType()
    {
        return $this->belongsTo(PersonDocumentType::class, 'person_document_type_id', 'id');
    }    
}
