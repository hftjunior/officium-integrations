<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VwObject extends Model
{
    protected $fillable = [
        'code', 'type', 'manufacture', 'model', 'status'
    ];
}
