<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\user;
use App\role;
use App\permission;

class ViewController extends Controller
{
    public function deparment()
    {
        $users = User::paginate();
        return view('department', compact('users'));
    }

    // Methods Permissions
    protected function getPermissions($User){
        $userCompare = '';

        if (strrpos($User, '@')) {
            $userCompare = 'email';
        } else {
            $userCompare = 'username';
        }
        

        $result = DB::table('permissions')
                        ->join('role_permission', 'permissions.id', '=', 'role_permission.Permission_id')
                        ->join('roles', 'roles.id', '=', 'role_permission.role_id')
                        ->join('user_role', 'roles.id', '=', 'user_role.role_id')
                        ->join('users', 'users.id', '=', 'user_role.user_id')
                        ->select('permissions.slug')
                        ->where('users.'.$userCompare, $User)
                        ->get();

        echo $result->toJson();
    }

    protected function getPermissionsAll(){
        $permissions = Permission::all();
        return $permissions;
    }

    protected function setEdit($id){
        $user = User::find($id);

        $permissions = DB::table('permissions')
                        ->join('users_permission' , 'permissions.id' , '=' , 'users_permission.Permission_id')
                        ->join( 'users' , 'users.id' , '=' , 'users_permission.User_id')
                        ->select('permissions.id')
                        ->where('users.id' , $id)
                        ->get();

        $role = DB::table('roles')
                        ->join('user_role' , 'roles.id' , '=' , 'user_role.role_id')
                        ->join( 'users' , 'users.id' , '=' , 'user_role.user_id')
                        ->select('roles.id')
                        ->where('users.id' , $id)
                        ->get();
        $user->permissions = $permissions;
        $user->role = $role;

        return $user;
    }
}
