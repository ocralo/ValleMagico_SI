<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Role;
use App\Permission;
use App\RolePermission;

class RoleController extends Controller
{
    protected function getRolesAll() {
        $roles = Role::all();
        return $roles;
    }

    protected function getRole($id) {
        $role = Role::find($id);

        $permissions = DB::table('permissions')
                        ->join('role_permission', 'permissions.id', '=', 'role_permission.permission_id')
                        ->join('roles', 'roles.id', '=', 'role_permission.role_id')
                        ->select('permissions.id')
                        ->where('roles.id' , $id)
                        ->get();

        $role->permissions = $permissions;

        return $role;
    }

    protected function createRole(Request $request) {
        $request->validate([
            'name'=>'required',
            'desc'=>'required',
            'permissions'=> 'required'
        ]);
        $level_permission = $request->get('permissions')[0];
        // < 5 because since that id, is not necessary to connect to location
        if ($level_permission < 5) {
            $permission = DB::table('permissions')->select('slug')->where('id', $level_permission)->first();
            $slug = $permission->slug;
            $destiny_hierarchy = DB::table('destiny_hierarchies')->select('id')->where('table_name', $slug)->first();
            $destiny_hierarchy_id = $destiny_hierarchy->id ?? null;
        } else {
            $destiny_hierarchy_id = $level_permission;
        }

        $role = new Role([
            'name' => $request->get('name'),
            'slug' => $request->get('name'),
            'desc' => $request->get('desc'),
            'destiny_hierarchy_id' => $destiny_hierarchy_id ?? null
        ]);
        $role->save();
        if (!$role) return json_encode(array('error'=>'There was an error saving the info related with the role.'));

        $permissions = $request->get('permissions');

        foreach ($permissions as $key => $permission) {
            $permissionsDB = Permission::where('id', $permission)->first();
            $new_role_permission = new RolePermission(['role_id' => $role->id, 'permission_id' => $permission]);
            $new_role_permission->save();
            if (!$new_role_permission) return json_encode(array('error'=>'There was an error saving the info with the relation role-permission.'));
        }
    }

    protected function updateRole( Request $request, $id) {
        $request->validate([
            'name'=>'required',
            'desc'=>'required',
            'permissions'=>'required',
        ]);
        $level_permission = $request->get('permissions')[0];
        // < 5 because since that id, is not necessary to connect to location
        if ($level_permission < 5) {
            $permission = DB::table('permissions')->select('slug')->where('id', $level_permission)->first();
            $slug = $permission->slug;
            $destiny_hierarchy = DB::table('destiny_hierarchies')->select('id')->where('table_name', $slug)->first();
            $destiny_hierarchy_id = $destiny_hierarchy->id ?? null;
        }

        $role = Role::find($id);
        if (!$role) return json_encode(array('error'=>'There is not a role with the id given.'));

        $role->name = $request->get('name');
        $role->name = $request->get('name');
        $role->desc = $request->get('desc');
        $role->destiny_hierarchy_id = $destiny_hierarchy_id;
        $role->save();

        if (!$role) return json_encode(array('error'=>'There was an error updating the role.'));

        $permissions = $request->get('permissions');

        $role->permissions()->where('permission.id')->wherePivot('role_id', $id)->detach();

        foreach ($permissions as $key => $value) {
            $permission = Permission::where('id', $value)->first();
            $role->permissions()->attach($permission);
        }

        // return redirect('/Role')->with('success', 'Contact saved!');
    }

    protected function destroyRole($id){
        $role = Role::find($id);
        if (!$role) return json_encode(array('error'=>'There is not a role with the id given.'));

        // $role->permissions()->where('permission.id')->wherePivot('role_id', $id)->detach();
        DB::table('role_permission')->where('role_id', $id)->delete();
        $role->users()->where('users.id')->wherePivot('role_id', $id)->detach();

        $role->delete();
        // return redirect('/Roles')->with('success', 'Contact saved!');
    }
}
