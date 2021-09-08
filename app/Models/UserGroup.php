<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGroup extends Model
{
    public $incrementing = false;
    public $timestamps = false;
    protected $keyType = 'string';
    protected $primaryKey = 'login';
    protected $table = 'users_groups';

    protected $fillable = [
        'login', 'group_id',
    ];
}
