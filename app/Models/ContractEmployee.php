<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractEmployee extends Model
{
    protected $fillable = [
        'contract_id', 'person_employee_id', 'contract_measure_id', 'franchise',
        'franchise_value', 'unitary', 'availability'
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function personEmployee()
    {
        return $this->belongsTo(PersonEmployee::class, 'person_employee_id', 'id');
    }

    public function measure()
    {
        return $this->belongsTo(ContractMeasure::class, 'contract_measure_id', 'id');
    }
}
