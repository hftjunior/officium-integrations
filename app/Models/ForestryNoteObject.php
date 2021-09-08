<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteObject extends Model
{
    protected $fillable = [
        'forestry_note_id', 'object_id'
    ];

    public function florestryNote()
    {
        return $this->belongsTo(FlorestryNote::class, 'forestry_note_id', 'id');
    }

}
