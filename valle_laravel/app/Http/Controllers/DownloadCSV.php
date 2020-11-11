<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

class DownloadCSV extends Controller
{
    function getDataByDepartment() {

    }

    function getDataByTown() {

    }

    function getDataByInstitution() {

    }

    function getDataByHeadquarter($headquarterID) {
        $headquarter =  DB::table('game_users')
        ->select('hq.name as headquarter','grades.name as grade','game_users.*', DB::raw('SUM(gur.total_score) as total'))
        ->join('grades', 'game_users.grade_id', '=', 'gades.id')
        ->join('subject_mini_game as smg', 'smg.mini_game_id', '=', 'gur.mini_game_id')
        ->join('subjects as s', 'smg.subject_id', '=', 's.id')
        ->groupBy('s.id')
        ->get();
        return $headquarter;
    }
    function getDataByStudent() {

    }
}
