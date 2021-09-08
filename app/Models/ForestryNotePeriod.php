<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNotePeriod extends Model
{
    protected $fillable = [
        'dtinitial', 'dtfinal', 'person_related_id', 'result_center_id', 'status'
    ];

    public function personRelated()
    {
        return $this->belongsTo(PersonRelated::class, 'person_related_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class, 'result_center_id', 'id');
    }
}
