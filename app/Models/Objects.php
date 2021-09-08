<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Objects extends Model
{
    protected $fillable = [
        'people_id', 'code', 'oldcode', 'object_status_id', 'serie', 'object_type_id',
        'object_manufacture_id', 'object_model_id', 'year_manufacture', 'year_model',
        'capacity', 'unit', 'power', 'cylinder', 'object_traction_id', 'consumption',
        'object_fuel_id', 'capacity_fuel', 'unit_fuel', 'service', 'responsible_id', 'notes'
    ];

    public function fuel()
    {
        return $this->belongsTo(ObjectFuel::class, 'object_fuel_id', 'id');
    }

    public function traction()
    {
        return $this->belongsTo(ObjectTraction::class, 'object_traction_id', 'id');
    }

    public function manufacture()
    {
        return $this->belongsTo(ObjectManufacture::class, 'object_manufacture_id', 'id');
    }

    public function model()
    {
        return $this->belongsTo(ObjectModel::class, 'object_model_id', 'id');
    }

    public function status()
    {
        return $this->belongsTo(ObjectStatus::class, 'object_status_id', 'id');
    }

    public function type()
    {
        return $this->belongsTo(ObjectType::class, 'object_type_id', 'id');
    }

    public function owner()
    {
        return $this->belongsTo(Person::class, 'people_id', 'id');
    }

    public function responsible()
    {
        return $this->belongsTo(Person::class, 'responsible_id', 'id');
    }

    public function codeAgency()
    {
        return $this->hasMany(ObjectCodeAgency::class, 'object_id', 'id');
    }
}
