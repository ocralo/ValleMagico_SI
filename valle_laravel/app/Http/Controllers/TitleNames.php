<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TitleNames extends Controller
{
    public function departmentName ($id) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $department = json_decode(file_get_contents($open_location.'api/department/'.$id), true);
        return $department;
    }

    public function townName ($id) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $town = json_decode(file_get_contents($open_location.'api/towns/'.$id), true);
        return $town;
    }

    public function institutionName ($id) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $institution = json_decode(file_get_contents($open_location.'api/institutions/'.$id), true);
        return $institution;
    }

    public function headquarterName ($id) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $headquarter = json_decode(file_get_contents($open_location.'api/headquarters/'.$id), true);
        return $headquarter;
    }

    public function groupName ($id) {
        $group = DB::table('grades')->select('name')->where('id', $id)->get();
        return $group;
    }

    public function studentName ($id) {
        $student = DB::table('game_users')->select('first_name', 'second_name', 'first_surname', 'second_surname')->where('id', $id)->get();
        return $student;
    }
}
