<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntLocation extends Model
{
    protected $fillable = [
        'int_region_id', 'int_project_id', 'location', 'area', 'active', 'own'
    ];

    public function region()
    {
        return $this->belongsTo(IntRegion::class, 'int_region_id', 'id');
    }

    public function project()
    {
        return $this->belongsTo(IntProject::class, 'int_project_id', 'id');
    }
}
