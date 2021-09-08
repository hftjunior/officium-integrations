<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ObjectImplement extends Model
{
    protected $fillable = [
        'code', 'type', 'manufacture', 'model', 'status'
    ];
}
