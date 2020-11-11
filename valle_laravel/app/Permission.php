<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\user;


class Permission extends Model
{
    // funtion that return relation to permissions with roles 
    public function roles(){
        return $this->belongsToMany(Role::class,'role_permission');

    }
    // public function users(){
    //     return $this->belongsToMany(User::class,'users_permission');

    // }
}
