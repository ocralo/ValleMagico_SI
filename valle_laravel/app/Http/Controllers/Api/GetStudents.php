<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use Config;

class GetStudents extends Controller
{
    protected function get($locationType, $locationId) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $students_array = [];
        if ($locationType === 'department' || $locationType === 'town' || $locationType === 'institution') {
            $info_from_location = json_decode(file_get_contents($open_location.'api/'.$locationType.'sHeadquarters/'.$locationId));

            foreach ($info_from_location as $key => $headquarter) {
                $student_from_db = DB::table('game_users')
                                    ->where('headquarter_id', $headquarter->id)
                                    ->get();

                foreach ($student_from_db as $key => $student) {
                    $to_push_student = (object) array('id' => $student->id,
                                                    'first_name' => $student->first_name,
                                                    'second_name' => $student->second_name,
                                                    'first_surname' => $student->first_surname,
                                                    'second_surname' => $student->second_surname,
                                                    'username' => $student->username);
                    array_push($students_array, $to_push_student);
                }
            }
        }

        return $students_array;
    }
}
