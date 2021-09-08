<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Operation extends Model
{
    protected $fillable = [
        'code', 'operation', 'type', 'status', 'sgf_id'
    ];

    public function notes()
    {
        return $this->hasMany(OperationNote::class, 'operation_id', 'id');
    }

    public function products()
    {
        return $this->hasMany(OperationHasProduct::class, 'operation_id', 'id');
    }

    public function moviments()
    {
        return $this->hasMany(IntOperationHasMoviment::class, 'operation_id', 'id');
    }

}
