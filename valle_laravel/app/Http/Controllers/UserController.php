<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use App\User;
use App\Role;
use App\UserHierarchy;

class UserController extends Controller
{
    protected function getUsersAll()
    {
        $users = User::all();
        return $users;
    }

    protected function getUser($id)
    {
        $user = User::find($id);
        if (!$user) return json_encode(array('error' => 'There is not an user with the id given.'));

        $role = DB::table('roles')
            ->join('user_role', 'roles.id', '=', 'user_role.role_id')
            ->join('users', 'users.id', '=', 'user_role.user_id')
            ->join('user_hierarchies AS uh', 'uh.user_id', '=', 'users.id')
            ->select('roles.id', 'uh.destiny_hierarchy_id')
            ->where('users.id', $id)
            ->get();

        $user->role_id = $role[0]->id;
        $user_hierarchies = [];
        foreach ($role as $key => $element) {
            array_push($user_hierarchies, $element->destiny_hierarchy_id);
        }
        $user->destiny_ids = $user_hierarchies;

        return $user;
    }

    protected function createUser(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'password' => 'required',
            'role' => 'required',
            'destiny_ids' => 'required'
        ]);

        $user = new User([
            'name' => $request->get('name'),
            'username' => $request->get('username'),
            'email' => $request->get('email'),
            'password' => $request->get('password')
        ]);

        $user->password = bcrypt($user->password);
        $user->save();
        if (!$user) return json_encode(array('error' => 'There was an error saving the user.'));

        $roleDB = Role::where('id', $request->get('role'))->first();
        $user->roles()->attach($roleDB);

        $destiny_ids = $request->get('destiny_ids');

        foreach ($destiny_ids as $key => $value) {
            $user_hierarchy = new UserHierarchy(['user_id' => $user->id, 'destiny_hierarchy_id' => $value]);
            $user_hierarchy->save();
            if (!$user_hierarchy) return json_encode(array('error' => 'There was an error saving the info about hierarchies.'));
        }

        // return redirect('/Usuarios')->with('success', 'Contact saved!');
    }

    protected function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required',
            'username' => 'required',
            'role' => 'required',
            'destiny_ids' => 'required'
        ]);

        $user = User::find($id);
        $user->name = $request->get('name');
        $user->username = $request->get('username');
        $user->email = $request->get('email');
        $user->save();

        $role = $request->get('role');

        $user->roles()->where('roles.id')->wherePivot('user_id', $id)->detach();

        $roleDB = Role::where('id', $role)->first();
        $user->roles()->attach($roleDB);

        $user_hierarchies = DB::table('user_hierarchies')->where('user_id', $user->id)->delete();
        if (!$user_hierarchies) return json_encode(array('error' => 'There was an error updating the info about hierarchies.'));

        $destiny_ids = $request->get('destiny_ids');
        foreach ($destiny_ids as $key => $value) {
            $user_hierarchy = new UserHierarchy(['user_id' => $user->id, 'destiny_hierarchy_id' => $value]);
            $user_hierarchy->save();
            if (!$user_hierarchy) return json_encode(array('error' => 'There was an error updating the info about hierarchies.'));
        }

        // return redirect('/Usuarios')->with('success', 'Contact saved!');
    }

    protected function destroyUser($id)
    {
        $user = User::find($id);
        $user->roles()->where('roles.id')->wherePivot('user_id', $id)->detach();

        $user_hierarchies = DB::table('user_hierarchies')->where('user_id', $user->id)->delete();

        $user->delete();
        if (!$user) return json_encode(array('error' => 'There was an error deleting the user.'));
        // return redirect('/Usuarios')->with('success', 'Contact saved!');
    }
    //Eliminar
    protected function getByUsername($username)
    {
        $user = DB::table('users')->where('username', $username)->get();
        return $user->toJson();
    }
}
