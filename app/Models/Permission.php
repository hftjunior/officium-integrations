<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use SoftDeletes;
    
    protected $fillable = [
        'name', 'slug', 'description'
    ];
}
