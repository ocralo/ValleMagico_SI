<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use App\HasPermissionsTrait;

class User extends Authenticatable
{
    use Notifiable , HasPermissionsTrait;


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password','username'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Computes and returns the User Hierarchy associated with de current User instance/row
     * @return Array<UserHierarchy>
     */
    public function userHierarchies(){
        return $this->hasMany('App\UserHierarchy');
    }

    /**
     * Computes and returns the User Crud Record associated with de current User instance/row
     * @return Array<UserCrudRecord>
     */
    public function userCrudRecords(){
        return $this->hasMany('App\UserCrudRecord');
    }
}
