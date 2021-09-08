<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    protected $fillable = [
        'person_id', 'number', 'contract_purpose_id', 'contract_type_id',
        'dtensue', 'dtend', 'status', 'notes'
    ];

    public function personProvider()
    {
        return $this->belongsTo(PersonProvider::class, 'person_id', 'id');
    }

    public function contractPurpose()
    {
        return $this->belongsTo(ContractPurpose::class, 'contract_type_id', 'id');
    }

    public function contractType()
    {
        return $this->belongsTo(ContractType::class, 'contract_type_id', 'id');
    }
    
    public function contractEmployees()
    {
        return $this->hasMany(ContractEmployee::class, 'contract_id', 'id');
    }    

    public function contractObjects()
    {
        return $this->hasMany(ContractObject::class, 'contract_id', 'id');
    }
    
    public function contractProducts()
    {
        return $this->hasMany(ContractProduct::class, 'contract_id', 'id');
    }
    
}
