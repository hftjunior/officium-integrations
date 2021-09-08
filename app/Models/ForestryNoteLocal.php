<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteLocal extends Model
{
    protected $fillable = [
        'forestry_note_id', 'int_location_id', 'amount', 'close',
        'rework', 'reapplication', 'florestry_cause_id', 'uniqid', 'notes', 'idcroci'
    ];

    public function florestryNote()
    {
        return $this->belongsTo(FlorestryNote::class, 'florestry_note_id', 'id');
    }

    public function intLocation()
    {
        return $this->belongsTo(IntLocation::class, 'int_location_id', 'id');
    }

}
