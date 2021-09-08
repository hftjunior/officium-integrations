<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PersonEmployeeRoleHasCategory extends Model
{
    protected $fillable = [
        'role_id', 'category_id'
    ];

    public function role()
    {
        return $this->belongsTo(PersonEmployeeRole::class, 'role_id', 'id');
    }

    public function category()
    {
        return $this->belongsTo(PersonEmployeeRoleCategory::class, 'category_id', 'id');
    }

}
