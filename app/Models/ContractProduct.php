<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContractProduct extends Model
{
    protected $fillable = [
        'contract_id', 'product_id', 'contract_measure_id', 
        'franchise', 'franchise_value', 'unitary', 'availability',
    ];

    public function contract()
    {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    public function measure()
    {
        return $this->belongsTo(ContractMeasure::class, 'contract_measure_id', 'id');
    }
}
