<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectNoteOperation extends Model
{
    protected $fillable = [
        'object_id', 'implement_id','operator_id','shift_id','dtnote','ped_initial','ped_final',
        'amount','measure_id','result_center_id','responsible_id','code_smart','notes'
    ];

    public function objectNoteMeassure()
    {
        return $this->belongsTo(ObjectNoteMeasure::class, 'measure_id', 'id');
    }

    public function object()
    {
        return $this->belongsTo(Object::class, 'object_id', 'id');
    }

    public function operator()
    {
        return $this->belongsTo(PersonEmployees::class, 'operator_id', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(PersonEmployees::class, 'responsible_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class, 'result_center_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(PersonEmployeeShift::class, 'shift_id', 'id');
    }

    public function factors()
    {
        return $this->hasMany(ObjectNoteOperationFactor::class, 'note_operations_id', 'id');
    }
    
}
