<?php
namespace App;

use App\Permission;
use App\Role;

trait HasPermissionsTrait {

    // Role Functions
   public function roles() {
      return $this->belongsToMany(Role::class,'user_role');

   }

   public function hasRole( ... $roles ) {
    foreach ($roles as $role) {
        if ($this->role->contains('slug', $role)) {
            return true;
        }
    }
    return false;
}

   public function permissions() {
      return $this->belongsToMany(Permission::class,'users_permission');

   }

   public function hasPermissionTo($permission) {
    return $this->hasPermissionThroughRole($permission) || $this->hasPermission($permission);
}

public function hasPermissionThroughRole($permission) {
    foreach ($permission->role as $role){
        if($this->role->contains($role)) {
            return true;
        }
    }
    return false;
}

public function givePermissionsTo(... $permissions) {
    $permissions = $this->getAllPermissions($permissions);
    dd($permissions);
    if($permissions === null) {
       return $this;
    }
    $this->permissions()->saveMany($permissions);
    return $this;
 }

 public function deletePermissions( ... $permissions ) {
    $permissions = $this->getAllPermissions($permissions);
    $this->permissions()->detach($permissions);
    return $this;
 }

}