<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class App extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';

    protected $primaryKey = 'app_name'; 

    protected $fillable = [
        'app_type', 'description'
    ];


}
