<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Person extends Model
{
    protected $fillable = [
        'name', 'cpfcnpj', 'type','photo', 'notes'
    ];

    public function personAddresses()
    {
        return $this->hasMany(PersonAddress::class, 'person_id','id');
    }

    public function personPhones()
    {
        return $this->hasMany(PersonPhone::class, 'person_id', 'id');
    }

    public function personEmails()
    {
        return $this->hasMany(PersonEmail::class, 'person_id', 'id');
    }

    public function personCategories()
    {
        return $this->belongsToMany(PersonCategory::class, 'person_has_categories', 'person_id', 'person_category_id');
    }

    public function objectsOwner()
    {
        return $this->hasMany(Object::class, 'people_id', 'id');
    }

    public function objectsResponsible()
    {
        return $this->hasMany(Object::class, 'responsible_id', 'id');
    }

    public function provider()
    {
        return $this->hasOne(PersonProvider::class, 'people_id', 'id');
    }

    public function client()
    {
        return $this->hasOne(PersonClient::class, 'people_id', 'id');
    }
}
