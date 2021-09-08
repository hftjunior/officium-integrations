<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class IntProject extends Model
{
    protected $fillable = [
        'project', 'sgf_id'
    ];

    public function locations()
    {
        return $this->hasMany(IntLocation::class, 'int_project_id', 'id');
    }
}
