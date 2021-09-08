<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForestryNote extends Model
{
    protected $fillable = [
        'dtstart', 'dtend', 'operation_id', 'person_employee_id',
        'person_related_id', 'result_center_id', 'smartquestion',
        'forestry_note_status_id', 'forestry_note_period_id', 'croci'
    ];

    public function operation()
    {
        return $this->belongsTo(Operation::class, 'operation_id', 'id');
    }

    public function personEmployee()
    {
        return $this->belongsTo(PersonEmployee::class, 'person_employee_id', 'id');
    }

    public function personRelated()
    {
        return $this->belongsTo(PersonRelated::class, 'person_related_id', 'id');
    }

    public function resultCenter()
    {
        return $this->belongsTo(ResultCenter::class, 'result_center_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ForestryNoteStatus::class, 'forestry_note_status_id', 'id');
    }

    public function period()
    {
        return $this->belongsTo(ForestryNotePeriod::class, 'forestry_note_period_id', 'id');
    }
}
