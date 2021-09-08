<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntOperationHasMoviment extends Model
{
    public $incrementing = false;

    protected $primaryKey = ['int_moviment_type_id','operation_id'];

    protected $table = 'int_operation_has_moviment';

    public function moviment()
    {
        return $this->belongsTo(IntMovimentType::class, 'int_moviment_type_id', 'id');
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }
}
