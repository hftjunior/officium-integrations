<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNoteDescard extends Model
{
    protected $fillable = [
        'forestry_note_id', 'product_id', 'measure', 'part', 'expedition',
        'amount_received', 'amount_planted', 'amount_desc_sub', 'amount_desc_broken',
        'amount_desc_green', 'amount_desc_disease', 'amount_desc_total', 'perc_desc_total',
        'idcrocimudas'
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
