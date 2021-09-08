<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OperationNote extends Model
{
    protected $fillable = [
        'dtoperation', 'operation_id', 'int_location_id', 'person_related_id',
        'int_stock_location', 'result_center_id', 'qtde', 'sgf_id'
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class);
    }

    public function Location()
    {
        return $this->belongsTo(IntLocation::class);
    }

    public function personRelated()
    {
        return $this->belongsTo(PersonRelated::class);
    }

    public function stockLocation()
    {
        return $this->belongsTo(IntStockLocation::class);
    }

}
