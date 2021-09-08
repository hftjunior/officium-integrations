<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class GroupsApp extends Model
{
    public $incrementing = false;
    protected $keyType = 'string';
    protected $primaryKey = ['group_id','app_name'];   
    
    protected $fillable = [
        'priv_access', 'priv_insert', 'priv_delete', 'priv_update', 
        'priv_export', 'priv_print',
    ];

    public function group()
    {
        return $this->belongsTo(Group::class, 'group_id', 'group_id');
    }

    public function app()
    {
        return $this->belongsTo(App::class, 'app_name', 'app_name');
    }
}
