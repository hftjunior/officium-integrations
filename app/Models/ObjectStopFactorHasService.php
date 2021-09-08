<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectStopFactorHasService extends Model
{
    public $incrementing = false;
    
    protected $primaryKey = ['factor_id','service_id'];

    public function factor()
    {
        return $this->belongsTo(ObjectStopFactor::class, 'factor_id', 'id');
    }

    public function service()
    {
        return $this->belongsTo(ObjectStopFactorService::class, 'service_id', 'id');
    }
    
}
