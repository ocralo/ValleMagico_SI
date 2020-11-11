<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

use App\miniGame;
use App\GameUserRecord;

use Config;

class GetGamesPlayed extends Controller
{
    //
    protected function getByLocationType($locationType, $id, $intelligences = false) {
        $headquarters = getHeadquarters($locationType, $id);
        $quantity = $this->getAllGames($intelligences);
        $intelligences = $intelligences ? true : false;
        $most_played = $this->getMostOrLessPlayed('headquarter_id', $headquarters, 'most', $intelligences);
        $less_played = $this->getMostOrLessPlayed('headquarter_id', $headquarters, 'less', $intelligences);
        $average_info = $this->getAverage('headquarter_id', $headquarters, $intelligences);

        $toReturn = array('total_games' => $quantity, 'most_played'=>$most_played,
                        'less_played' => $less_played, 'average'=>$average_info);
        return $toReturn;
    }

    protected function getByHeadquarter($id, $intelligences = false) {
        $headquarters = [$id];
        $quantity = $this->getAllGames($intelligences);
        $intelligences = $intelligences ? true : false;
        $most_played = $this->getMostOrLessPlayed('headquarter_id', $headquarters, 'most', $intelligences);
        $less_played = $this->getMostOrLessPlayed('headquarter_id', $headquarters, 'less', $intelligences);
        $average_info = $this->getAverage('headquarter_id', $headquarters, $intelligences);

        $toReturn = array('total_games' => $quantity, 'most_played'=>$most_played,
                        'less_played' => $less_played, 'average'=>$average_info);
        return $toReturn;
    }

    protected function getByGrade($headquarter_id, $id, $intelligences = false) {
        $quantity = $this->getAllGames($intelligences);
        $gu_records_int = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                            ->join('game_user_records AS gur', 'gur.id', '=', 'guri.game_user_record_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select('gur.id')
                            ->where('gu.headquarter_id', $headquarter_id)
                            ->where('gu.grade_id', $id)
                            ->groupBy('gur.mini_game_id')
                            ->get()
                            ->toArray();
        $gu_records_int_array = [];
        foreach ($gu_records_int as $key => $value) {
            array_push($gu_records_int_array, $value->id);
        }

        if ($intelligences) {
            $MoL_played = DB::table('game_user_records AS gur')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select(DB::raw('COUNT(*) AS quantity'), 'mg.name')
                            ->whereIn('gur.id', $gu_records_int_array)
                            ->groupBy('mg.name')
                            ->orderBy('quantity', 'ASC')
                            ->get()
                            ->toArray();
            $average_info = DB::table('game_user_records AS gur')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select('gu.id AS gu_id', 'mg.id')
                            ->whereIn('gur.id', $gu_records_int_array)
                            ->groupBy('gu.id', 'mg.id')
                            ->get();
        } else {
            $MoL_played = DB::table('game_user_records AS gur')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select(DB::raw('COUNT(*) AS quantity'), 'mg.name')
                            ->whereNotIn('gur.id', $gu_records_int_array)
                            ->where('gu.headquarter_id', $headquarter_id)
                            ->where('gu.grade_id', $id)
                            ->groupBy('mg.name')
                            ->orderBy('quantity', 'ASC')
                            ->get()
                            ->toArray();
            $average_info = DB::table('game_user_records AS gur')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select('gu.id AS gu_id', 'mg.id')
                            ->where('gu.headquarter_id', $headquarter_id)
                            ->where('gu.grade_id', $id)
                            ->whereNotIn('gur.id', $gu_records_int_array)
                            ->groupBy('gu.id', 'mg.id')
                            ->get();
        }
        $most_played = $MoL_played[sizeof($MoL_played) - 1] ?? null;
        $less_played = $MoL_played[0] ?? null;

        $average_array = [];
        foreach ($average_info as $key => $value) {
            if (!isset($average_array[$value->gu_id])) $average_array[$value->gu_id] = 0;
            $average_array[$value->gu_id]++;
        }
        $average_array = array_values($average_array);
        $average = isset($average_array[0]) ? array_sum($average_array) / count($average_array) : 0;

        $toReturn = array('total_games' => $quantity, 'most_played'=>$most_played,
                        'less_played' => $less_played, 'average'=>round($average, 2));
        return $toReturn;
    }

    protected function getByStudent($id, $intelligences = false) {
        $regex = '/^[A-Za-z]+[0-9]+/';
        $byUsername = preg_match($regex, $id);
        $toSearch = $byUsername ? 'username' : 'id';

        $ids = [$id];
        $quantity = $this->getAllGames($intelligences);
        $intelligences = $intelligences ? true : false;
        $most_played = $this->getMostOrLessPlayed($toSearch, $ids, 'most', $intelligences);
        $less_played = $this->getMostOrLessPlayed($toSearch, $ids, 'less', $intelligences);

        $gu_records_int = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                            ->join('game_user_records AS gur', 'gur.id', '=', 'guri.game_user_record_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select('gur.id')
                            ->where('gu.'.$toSearch, $id)
                            ->groupBy('gur.mini_game_id')
                            ->get()
                            ->toArray();
        $gu_records_int_array = [];
        foreach ($gu_records_int as $key => $value) {
            array_push($gu_records_int_array, $value->id);
        }

        if ($intelligences) {
            $games_played = GameUserRecord::whereIn('id', $gu_records_int_array)->count();
        } else {
            $games_played = DB::table('game_user_records AS gur')
                                ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                                ->whereNotIn('gur.id', $gu_records_int_array)
                                ->where('gu.'.$toSearch, $id)
                                ->groupBy('gur.mini_game_id')
                                ->get()
                                ->count();
        }

        $toReturn = array('total_games' => $quantity, 'most_played'=>$most_played,
                        'less_played' => $less_played, 'games_played'=>$games_played);
        return $toReturn;
    }

    protected function getAllGames($intelligences = false) {
        $total_games = 0;
        $intelligences_games = DB::table('mini_games')->select('id')->where('location_id', null)->get()->toArray();
        $intelligences_games_array = [];
        foreach ($intelligences_games as $key => $value) {
            array_push($intelligences_games_array, $value->id);
        }
        if ($intelligences) {
            $total_games = sizeof($intelligences_games_array);
        } else {
            $total_games = DB::table('mini_games')
                            ->whereNotIn('id', $intelligences_games_array)
                            ->where('name', 'NOT LIKE', 'CIU%')
                            ->get();
            $total_games = sizeof($total_games);
        }
        return $total_games;
    }

    protected function getMostOrLessPlayed($column_name, $ids_array, $type, $intelligences) {
        $MoL = $type === 'most' ? 'DESC' : 'ASC';
        $gu_records_int = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                            ->join('game_user_records AS gur', 'gur.id', '=', 'guri.game_user_record_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select('gur.id')
                            ->whereIn('gu.'.$column_name, $ids_array)
                            ->get()
                            ->toArray();
        $gu_records_int_array = [];
        foreach ($gu_records_int as $key => $value) {
            array_push($gu_records_int_array, $value->id);
        }

        if ($intelligences) {
            $MoL_played = DB::table('game_user_records AS gur')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select(DB::raw('COUNT(*) AS quantity'), 'mg.name')
                            ->whereIn('gur.id', $gu_records_int_array)
                            ->groupBy('mg.name')
                            ->orderBy('quantity', $MoL)
                            ->limit(1)
                            ->first();
        } else {
            $MoL_played = DB::table('game_user_records AS gur')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select(DB::raw('COUNT(*) AS quantity'), 'mg.name')
                            ->whereNotIn('gur.id', $gu_records_int_array)
                            ->whereIn('gu.'.$column_name, $ids_array)
                            ->groupBy('mg.name')
                            ->orderBy('quantity', $MoL)
                            ->limit(1)
                            ->first();
        }

        return $MoL_played;
    }

    protected function getAverage($column_name, $ids_array, $intelligences) {
        $gu_records_int = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                            ->join('game_user_records AS gur', 'gur.id', '=', 'guri.game_user_record_id')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->select('gur.id')
                            ->whereIn('gu.'.$column_name, $ids_array)
                            ->groupBy('gur.mini_game_id')
                            ->get()
                            ->toArray();
        $gu_records_int_array = [];
        foreach ($gu_records_int as $key => $value) {
            array_push($gu_records_int_array, $value->id);
        }

        if ($intelligences) {
            $average_info = DB::table('game_user_records AS gur')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select('gu.id AS gu_id', 'mg.id')
                            ->whereIn('gur.id', $gu_records_int_array)
                            ->groupBy('gu.id', 'mg.id')
                            ->get();
        } else {
            $average_info = DB::table('game_user_records AS gur')
                            ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                            ->select('gu.id AS gu_id', 'mg.id')
                            ->whereIn('gu.'.$column_name, $ids_array)
                            ->whereNotIn('gur.id', $gu_records_int_array)
                            ->groupBy('gu.id', 'mg.id')
                            ->get();
        }
        $average_array = [];
        foreach ($average_info as $key => $value) {
            if (!isset($average_array[$value->gu_id])) $average_array[$value->gu_id] = 0;
            $average_array[$value->gu_id]++;
        }
        $average_array = array_values($average_array);
        $average = isset($average_array[0]) ? array_sum($average_array) / count($average_array) : 0;
        return round($average, 2);
    }
}
