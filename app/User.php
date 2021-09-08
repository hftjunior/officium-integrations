<?php

namespace App;

use Tymon\JWTAuth\Contracts\JWTSubject;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Junges\ACL\Traits\UsersTrait;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable implements JWTSubject
{
    use Notifiable;
    use UsersTrait;
    //use SoftDeletes;
    /**
    * The primary key associated with the table.
    *
    * @var string
    */
    protected $primaryKey = 'login';
    public $incrementing = false;
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'login', 'pswd', 'name', 'email', 'active', 'activation_code', 'priv_admin'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'activation_code',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    /*
     protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function permissions()
    {
        return $this->belongsToMany(\Junges\ACL\Http\Models\Permission::class, 'user_has_permissions', 'user_id', 'permission_id');
    }

    public function groups()
    {
        return $this->belongsToMany(\Junges\ACL\Http\Models\Group::class, 'user_has_groups', 'user_id', 'group_id');
    }
    */
    /**
     * Get the identifier that will be stored in the subject claim of the JWT.
     *
     * @return mixed
     */
    public function getJWTIdentifier()
    {
        return $this->getKey();
    }

    /**
     * Return a key value array, containing any custom claims to be added to the JWT.
     *
     * @return array
     */
    public function getJWTCustomClaims()
    {
        return [];
    }

}
