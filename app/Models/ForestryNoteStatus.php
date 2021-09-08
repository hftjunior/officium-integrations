<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteStatus extends Model
{
    protected $fillable = [
        'status'
    ];

    public function notes()
    {
        return $this->hasMany(ForestryNote::class, 'forestry_note_status_id', 'id');
    }
}
