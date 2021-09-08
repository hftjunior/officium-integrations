<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CoalDcfLocation extends Model
{
    protected $fillable = [
        'coal_dcf_id', 'int_location_id', 'volwood',
        'volcharcoal', 'balance_wood', 'balance_charcoal'
    ];

    public function coalDcf()
    {
        return $this->belongsTo(CoalDcf::class);
    }

    public function location()
    {
        return $this->belongsTo(IntLocation::class);
    }
}
