<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectNoteFuelSupply extends Model
{
    protected $fillable = [
        'date', 'object_id','related_id','result_center_id','local_id',
        'operation_id', 'operator_id','pedometer','provider_id','product_id',
        'amount','val_unit','responsible_id','code','source','notes'
    ];

    public function object()
    {
        return $this->belongsTo(Object::class, 'object_id', 'id');
    }

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo(PersonEmployee::class, 'operator_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Products::class, 'product_id', 'id');
    }

    public function provider()
    {
        return $this->belongsTo(PersonProvider::class, 'provider_id', 'id');
    }

    public function related()
    {
        return $this->belongsTo(PersonRelated::class, 'related_id', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(PersonEmployee::class, 'responsible_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class, 'result_center_id', 'id');
    }

}
