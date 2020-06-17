<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildHierarchy extends Controller
{

    public function townsByDepartment ($id) {
        // $open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $towns = json_decode(file_get_contents($open_location.'api/townsByDepartment/'.$id), true);
        return $towns;
    }

    public function institutionsByTown ($id) {
        // $open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $institutions = json_decode(file_get_contents($open_location.'api/institutionsByTown/'.$id), true);
        return $institutions;
    }

    public function headquartersByInstitutions ($id){
        // $open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $headquarters = json_decode(file_get_contents($open_location.'api/headquartersByInstitution/'.$id), true);
        return $headquarters;
    }
    //
    public function groupsByHeadquarters () {
        $groups = DB::table('grades')->select('name', 'id')->get();
        return $groups;
    }

    public function studentsByGroups ($id1, $id2) {
        // $id = strtoupper($id);
        $students = DB::table('game_users')->select('first_name', 'second_name', 'first_surname', 'second_surname', 'id')->where('headquarter_id', $id1)->where('grade_id', $id2)->get();
        return $students;
    }
}
