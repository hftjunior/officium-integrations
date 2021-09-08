<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectNoteOperationFactor extends Model
{
    protected $fillable = [
        'note_operations_id', 'factor_id','initial','end','total_time','total_decimal', 'notes'
    ];

    public function objectStopFactor()
    {
        return $this->belongsTo(ObjectStopFactor::class, 'factor_id', 'id');
    }

    public function objectNoteOperation()
    {
        return $this->belongsTo(ObjectNoteOperation::class, 'note_operations_id', 'id');
    }
}
