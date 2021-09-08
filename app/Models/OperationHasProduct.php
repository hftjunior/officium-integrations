<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationHasProduct extends Model
{
    public $incrementing = false;

    protected $primaryKey = ['operation_id','product_id'];

    protected $table = 'operation_has_product';

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
