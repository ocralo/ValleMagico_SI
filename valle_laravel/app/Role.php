<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Permission;
use App\User;
// use App\HasPermissionsTrait;


class Role extends Model
{

    // use HasPermissionsTrait;
    protected $fillable = [
        'name', 'slug', 'desc', 'destiny_hierarchy_id'
    ];
    // funtion that return relation roles with permissions

    public function permissions() {
        return $this->belongsToMany(Permission::class,'role_permission');
    }

    public function users() {
        return $this->belongsToMany(User::class,'user_role');
    }

    public function destinyHierarchies() {
        return $this->belongsTo('App\DestinyHierarchy');
    }

    // public function users(){
    //     return $this->belongsToMany('App/Role');
    // }
}
