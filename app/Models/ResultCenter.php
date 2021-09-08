<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ResultCenter extends Model
{
    protected $fillable = [
        'related_id', 'code', 'result_center'
    ];

    public function related()
    {
        return $this->belongsTo(PersonRelated::class, 'related_id', 'id');
    }

    public function objectNoteOperation()
    {
        return $this->hasMany(ObjectNoteOperation::class, 'result_center_id', 'id');
    }

    public function objectNoteFuelSupply()
    {
        return $this->hasMany(ObjectNoteFuelSupply::class, 'result_center_id', 'id');
    }
}
