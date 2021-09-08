<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteManpower extends Model
{
    protected $table = 'forestry_note_manpower';

    protected $fillable = [
        'forestry_note_id', 'forestry_manpower_type_id', 'amount'
    ];

    public function florestryNote()
    {
        return $this->belongsTo(FlorestryNote::class, 'florestry_note_id', 'id');
    }

}
