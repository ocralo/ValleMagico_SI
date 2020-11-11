<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class Downloadcsv2 extends Controller
{
    function getDataByDepartment($departmentID) {
        $ol = env('OPEN_LOCATION_DB');

        $towns =  DB::table('game_users')
        ->select('tw.name as town','inst.name as institution','hq.name as headquarter','grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username', 'mgg.name as grade_mini_game', DB::raw('AVG(gur.total_score) as total'))
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->join($ol.'.headquarters as hq','game_users.headquarter_id','=','hq.id')
        ->join($ol.'.institutions as inst','inst.id','=','hq.institution_id')
        ->join($ol.'.towns as tw','tw.id','=','hq.town_id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->groupBy('s.id','mg.grade_id','game_users.id')
        ->orderBy('inst.id')
        ->orderBy('hq.id')
        ->orderBy('s.id')
        ->orderBy('grades.id')
        ->orderBy('game_users.id')
        ->orderBy('mg.grade_id')
        ->get();

        return $this->generateCSV($towns,['MUNICIPIO','INSTITUCIÓN','SEDE','GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);

    }

    function getDataByTown($townID) {
        $ol = env('OPEN_LOCATION_DB');
        $towns =  DB::table('game_users')
        ->select('tw.name as town','inst.name as institution','hq.name as headquarter','grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username', 'mgg.name as grade_mini_game', DB::raw('AVG(gur.total_score) as total'))
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->join($ol.'.headquarters as hq','game_users.headquarter_id','=','hq.id')
        ->join($ol.'.institutions as inst','inst.id','=','hq.institution_id')
        ->join($ol.'.towns as tw','tw.id','=','hq.town_id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->where('tw.id', $townID)
        ->groupBy('s.id','mg.grade_id','game_users.id')
        ->orderBy('inst.id')
        ->orderBy('hq.id')
        ->orderBy('s.id')
        ->orderBy('grades.id')
        ->orderBy('game_users.id')
        ->orderBy('mg.grade_id')
        ->get();

        return $this->generateCSV($towns,['MUNICIPIO','INSTITUCIÓN','SEDE','GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);

    }

    function getDataByInstitution($institutionID) {
        $ol = env('OPEN_LOCATION_DB');
        $institution =  DB::table('game_users')
        ->select('inst.name as institution','hq.name as headquarter','grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username', 'mgg.name as grade_mini_game', DB::raw('AVG(gur.total_score) as total'))
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->join($ol.'.headquarters as hq','game_users.headquarter_id','=','hq.id')
        ->join($ol.'.institutions as inst','inst.id','=','hq.institution_id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->where('hq.institution_id', $institutionID)
        ->groupBy('s.id','mg.grade_id','game_users.id')
        ->orderBy('inst.id')
        ->orderBy('hq.id')
        ->orderBy('s.id')
        ->orderBy('grades.id')
        ->orderBy('game_users.id')
        ->orderBy('mg.grade_id')
        ->get();

        return $this->generateCSV($institution,['INSTITUCIÓN','SEDE','GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);
    }

    function getDataByHeadquarter($headquarterID) {
        $ol = env('OPEN_LOCATION_DB');
        $headquarters =  DB::table('game_users')
        ->select('hq.name as headquarter','grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username','mgg.name as grade_mini_game', DB::raw('AVG(gur.total_score) as total'))
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->join($ol.'.headquarters as hq','game_users.headquarter_id','=','hq.id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->where('game_users.headquarter_id', $headquarterID)
        ->groupBy('s.id','mg.grade_id','game_users.id')
        ->orderBy('s.id')
        ->orderBy('grades.id')
        ->orderBy('game_users.id')
        ->orderBy('mg.grade_id')
        ->get();
        return $this->generateCSV($headquarters,['SEDE','GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);
    }

    function getDataByHeadquarterGroup($headquarterID,$groupID) {
        $ol = env('OPEN_LOCATION_DB');
        $headquarter =  DB::table('game_users')
        ->select('hq.name as headquarter','grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username', 'mgg.name as grade_mini_game', DB::raw('AVG(gur.total_score) as total'))
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->join($ol.'.headquarters as hq','game_users.headquarter_id','=','hq.id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->where('game_users.headquarter_id', $headquarterID)
        ->where('game_users.grade_id', $groupID)
        ->groupBy('s.id','mg.grade_id','game_users.id')
        ->orderBy('s.id')
        ->orderBy('grades.id')
        ->orderBy('game_users.id')
        ->orderBy('mg.grade_id')
        ->get();
        return $this->generateCSV($headquarter,['SEDE','GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);
    }

    function getDataByStudent($studentID) {
        $ol = env('OPEN_LOCATION_DB');
        $student =  DB::table('game_users')
        ->select('grades.name as grade','s.name','game_users.first_name','game_users.second_name','game_users.first_surname','game_users.second_surname','game_users.username','mgg.name as grade_mini_game',DB::raw('AVG(gur.total_score) as total'))
        ->join('grades', 'game_users.grade_id', '=', 'grades.id')
        ->join ('game_user_records as gur','gur.game_user_id','=','game_users.id')
        ->join('mini_games as mg', 'mg.id', '=', 'gur.mini_game_id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'mg.id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->leftJoin('grades as mgg', 'mg.grade_id', '=', 'mgg.id')
        ->where('game_users.id', $studentID)
        ->groupBy('s.id','mg.grade_id')
        ->orderBy('s.id')
        ->orderBy('mg.grade_id')
        ->get();
        return $this->generateCSV($student,['GRADO','ÁREA','PRIMER NOMBRE','SEGUNDO NOMBRE','PRIMER APELLIDO','SEGUNDO APELLIDO','NOMBRE DE USUARIO','GRADO MINIJUEGOS','TOTAL']);
    }

    private function generateCSV($result,$headers){
        $f = fopen('php://memory', 'w');
        fputcsv($f, array_map('utf8_decode',array_values($headers)), ';');
        foreach($result as $row){
            $fields = array();
            foreach ($row as $field => $value) {
                $replaced = str_replace('.',',',$value);
                array_push($fields,$replaced);
            }
            fputcsv($f, array_map('utf8_decode',array_values($fields)), ';');
        }
        fseek($f, 0);
            //set headers to download file rather than displayed
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . 'data.csv' . '";');

        //output all remaining data on a file pointer
        fpassthru($f);
    }
}
