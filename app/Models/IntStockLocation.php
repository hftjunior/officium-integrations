<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntStockLocation extends Model
{
    protected $fillable = [
        'person_related_id', 'result_center_id', 'int_location_id',
        'code', 'codfilial', 'description'
    ];

    public function personRelated()
    {
        return $this->belongsTo(PersonRelated::class, 'person_related_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class, 'result_center_id', 'id');
    }

    public function location()
    {
        return $this->belongsTo(IntLocation::class, 'int_location_id', 'id');
    }
}
