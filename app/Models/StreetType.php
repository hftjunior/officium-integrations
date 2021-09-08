<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StreetType extends Model
{
    protected $fillable = [
        'type', 'initial',
    ];

    public function personAddresses()
    {
        return $this->hasMany(PersonAdreess::class, 'street_type_id', 'id');
    }
}
