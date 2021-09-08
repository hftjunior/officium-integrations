<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractMeasure extends Model
{
    protected $fillable = [
        'measure', 'initial'
    ];

    public function contractsEmployees()
    {
        return $this->hasMany(ContractEmployee::class, 'contract_measure_id', 'id');
    }

    public function contractsObjects()
    {
        return $this->hasMany(ContractObject::class, 'contract_measure_id', 'id');
    }

    public function contractsProducts()
    {
        return $this->hasMany(ContractProduct::class, 'contract_measure_id', 'id');
    }
}
