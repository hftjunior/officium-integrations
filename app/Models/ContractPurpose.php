<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractPurpose extends Model
{
    protected $fillable = [
        'purpose'
    ];

    public function contracts()
    {
        return $this->hasMany(Contract::class, 'contract_purpose_id', 'id');
    }
}
