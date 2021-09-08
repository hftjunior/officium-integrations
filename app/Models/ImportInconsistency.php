<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImportInconsistency extends Model
{
    protected $fillable = [
        'user', 'application', 'spreadsheet', 'description', 'line'
    ];
}
