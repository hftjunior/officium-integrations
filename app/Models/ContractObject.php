<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractObject extends Model
{
    protected $fillable = [
        'contract_id', 'object_id', 'contract_measure_id', 'franchise',
        'franchise_value', 'unitary', 'availability'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function object()
    {
        return $this->belongsTo(Object::class, 'object_id', 'id');
    }

    public function contractMeasure()
    {
        return $this->belongsTo(ContractMeasure::class, 'contract_measure_id', 'id');
    }    
}
