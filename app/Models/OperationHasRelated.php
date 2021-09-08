<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationHasRelated extends Model
{
    public $incrementing = false;
    
    protected $primaryKey = ['operation_id','related_id'];

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }

    public function related()
    {
        return $this->belongsTo(PersonRelated::class, 'related_id', 'id');
    }
}
