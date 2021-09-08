<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteInput extends Model
{
    protected $fillable = [
        'forestry_note_id', 'product_id', 'amount', 'measure', 'idcrociinsumo'
    ];

    public function florestryNote()
    {
        return $this->belongsTo(FlorestryNote::class, 'forestry_note_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

}
