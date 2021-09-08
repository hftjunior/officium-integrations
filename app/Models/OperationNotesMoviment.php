<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationNotesMoviment extends Model
{
    protected $fillable = [
        'operation_notes_id', 'int_moviment_type_id', 'product_id', 'integration'
    ];

    public function moviment()
    {
        return $this->belongsTo(IntMovimentType::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
