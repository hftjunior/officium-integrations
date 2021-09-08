<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmployee extends Model
{
    protected $fillable = [
        'code', 'people_id', 'employer_id', 'gender', 'dtbirth',
        'nationaly', 'placebirth_id', 'state_id', 'dtadmission', 'dtdemission',
        'role_id', 'salary', 'payment_id', 'shift_id', 'status', 'notes'
    ];

    public function employee()
    {
        return $this->belongsTo(Person::class, 'people_id', 'id');
    }

    public function payment()
    {
        return $this->belongsTo(PersonEmployeePayment::class, 'payment_id', 'id');
    }

    public function employer()
    {
        return $this->belongsTo(Person::class,'employer_id', 'id');
    }

    public function placeBirth()
    {
        return $this->belongsTo(City::class, 'placebirth_id', 'id');
    }

    public function state()
    {
        return $this->belongsTo(State::class, 'state_id', 'id');
    }

    public function role()
    {
        return $this->belongsTo(PersonEmployeeRole::class, 'role_id', 'id');
    }

    public function shift()
    {
        return $this->belongsTo(PersonEmployeeShift::class, 'shift_id', 'id');
    }
            
}
