<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntMovimentType extends Model
{
    protected $fillable = [
        'code', 'moviment', 'type', 'product_id'
    ];

    public function moviments()
    {
        return $this->hasMany(IntOperationHasMoviment::class, 'int_moviment_type_id', 'id');
    }
}
