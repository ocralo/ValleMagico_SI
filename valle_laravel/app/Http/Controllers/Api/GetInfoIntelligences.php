<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Http\Controllers\Controller;

class GetInfoIntelligences extends Controller
{
    protected function getOne($username) {
        $toReturn = array();
        $regex = '/^[A-Za-z]+[0-9]+/';
        $byUsername = preg_match($regex, $username);
        $toSearch = $byUsername ? 'username' : 'id';

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
                        ->join('intelligence_indicators AS intInd', 'intInd.id', '=',
                            'bridge_table.intelligence_indicator_id')
                        ->join('intelligences AS ints', 'ints.id', '=', 'intInd.intelligence_id')
                        ->join(DB::raw("(SELECT inti.description, inti.id, gur.mini_game_id, mg.grade_id
                            FROM intelligence_indicators AS inti
                            JOIN gu_record_intelligence_ind_desc_styles guri 
                            ON guri.intelligence_indicator_id = inti.id 
                            JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
                            JOIN game_users gu ON gu.id = gur.game_user_id
                            JOIN mini_games mg ON mg.id = gur.mini_game_id
                            WHERE gu.".$toSearch." = ? GROUP BY inti.id) AS joinS"), 
                            'joinS.id', '=', 'bridge_table.intelligence_indicator_id')
                        ->addBinding($username)
                        ->select('ints.name AS name', DB::raw('GROUP_CONCAT(joinS.description SEPARATOR "--") AS all_desc'), 
                            DB::raw('SUM(bridge_table.percentage_value) AS average'))
                        // ->select('ints.name AS int_name', 'joinS.description', 'bridge_table.percentage_value', 'joinS.grade_id', 'joinS.name')
                        ->whereRaw('bridge_table.game_user_record_id IN
                            (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
                            ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
                        ->groupBy('ints.name')
                        ->get();

        if (!empty($result[0])) {
            foreach ($result as $key => $element) {
                $help_var = $element->all_desc;
                unset($result[$key]->all_desc);
                $result[$key]->all_desc = [];
                if (strrpos($help_var, '--')) {
                    $result[$key]->all_desc = explode("--", $help_var);
                } else {
                    $result[$key]->all_desc = array($help_var);
                }
            }
            http_response_code(200);
            return $result;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getOneByGrade($username) {
        // if (Redis::get('intelligences-'.$username)) {
        //     $result = json_decode(Redis::get('intelligences-'.$username));
        // } else {
            $toReturn = array();
            $regex = '/^[A-Za-z]+[0-9]+/';
            $byUsername = preg_match($regex, $username);
            $toSearch = $byUsername ? 'username' : 'id';

            // $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
            //             ->join('intelligence_indicators AS intInd', 'intInd.id', '=',
            //                 'bridge_table.intelligence_indicator_id')
            //             ->join('intelligences AS ints', 'ints.id', '=', 'intInd.intelligence_id')
            //             ->join(DB::raw("(SELECT GROUP_CONCAT(inti.description SEPARATOR '--') AS all_desc, 
            //                 inti.id, gur.mini_game_id FROM intelligence_indicators AS inti
            //                 JOIN gu_record_intelligence_ind_desc_styles guri 
            //                 ON guri.intelligence_indicator_id = inti.id 
            //                 JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
            //                 JOIN game_users gu ON gu.id = gur.game_user_id
            //                 WHERE gu.".$toSearch." = ? GROUP BY intelligence_id) AS joinS"), 
            //                 'joinS.id', '=', 'bridge_table.intelligence_indicator_id')
            //             ->addBinding($username)
            //             ->select('bridge_table.percentage_value', 'ints.name AS int_name',
            //                 'joinS.all_desc', 'joinS.mini_game_id',
            //                 DB::raw('SUM(bridge_table.percentage_value) AS total'))
            //             ->whereRaw('bridge_table.game_user_record_id IN
            //                 (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
            //                 ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
            //             ->groupBy('ints.id')
            //             ->get();
            $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
                        ->join('intelligence_indicators AS intInd', 'intInd.id', '=',
                            'bridge_table.intelligence_indicator_id')
                        ->join('intelligences AS ints', 'ints.id', '=', 'intInd.intelligence_id')
                        ->join(DB::raw("(SELECT inti.description, inti.id, gur.mini_game_id, mg.grade_id, gr.name 
                            FROM intelligence_indicators AS inti
                            JOIN gu_record_intelligence_ind_desc_styles guri 
                            ON guri.intelligence_indicator_id = inti.id 
                            JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
                            JOIN game_users gu ON gu.id = gur.game_user_id
                            JOIN mini_games mg ON mg.id = gur.mini_game_id
                            JOIN grades gr ON gr.id = mg.grade_id
                            WHERE gu.".$toSearch." = ? GROUP BY inti.id) AS joinS"), 
                            'joinS.id', '=', 'bridge_table.intelligence_indicator_id')
                        ->addBinding($username)
                        // ->select('ints.name AS int_name', DB::raw('GROUP_CONCAT(joinS.description SEPARATOR "--") AS all_desc'), 
                        //     DB::raw('SUM(bridge_table.percentage_value) AS total'))
                        ->select('ints.name AS int_name', 'joinS.description', 'bridge_table.percentage_value', 'joinS.grade_id', 'joinS.name')
                        ->whereRaw('bridge_table.game_user_record_id IN
                            (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
                            ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
                        // ->groupBy('ints.id')
                        ->get();

            $descriptions_arr = [];
            $percentage_values_arr = [];
            foreach ($result as $key => $element) {
                if (!isset($toReturn[$element->name])) $toReturn[$element->name] = [];
                if (!isset($toReturn[$element->name][$element->int_name])) $toReturn[$element->name][$element->int_name] = [];
                if (!isset($descriptions_arr[$element->name.'-'.$element->int_name])) $descriptions_arr[$element->name.'-'.$element->int_name] = [];
                if (!isset($percentage_values_arr[$element->name.'-'.$element->int_name])) $percentage_values_arr[$element->name.'-'.$element->int_name] = [];
                array_push($descriptions_arr[$element->name.'-'.$element->int_name], $element->description);
                array_push($percentage_values_arr[$element->name.'-'.$element->int_name], $element->percentage_value);
            }
            foreach ($toReturn as $key_gr => $grade_arr) {
                foreach ($grade_arr as $key => $element) {
                    $toReturn[$key_gr][$key]['int_name'] = $key;
                    if (!isset($toReturn[$key_gr][$key]['average'])) $toReturn[$key_gr][$key]['average'] = [];
                    array_push($toReturn[$key_gr][$key]['average'], $percentage_values_arr[$key_gr.'-'.$key]);
                    if (!isset($toReturn[$key_gr][$key]['descriptions'])) $toReturn[$key_gr][$key]['descriptions'] = [];
                    array_push($toReturn[$key_gr][$key]['descriptions'], $descriptions_arr[$key_gr.'-'.$key]);
                }
                foreach ($grade_arr as $key => $element) {
                    $toReturn[$key_gr][$key]['average'] = array_sum($toReturn[$key_gr][$key]['average'][0]) / count($toReturn[$key_gr][$key]['average'][0]);
                    $toReturn[$key_gr][$key]['descriptions'] = $toReturn[$key_gr][$key]['descriptions'][0];
                }
                $toReturn[$key_gr] = array_values($toReturn[$key_gr]);
            }
            return $toReturn;

        //     !empty($result[0]) ? Redis::set('intelligences-'.$username, $result->toJson()) : null;
        // }
        
        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getMoreThanOne(Request $request) {
        $result_arr = [];
        $request_arr = $request->all();
        foreach ($request_arr as $key => $username) {
            $regex = '/^[A-Za-z]+[0-9]+/';
            $byUsername = preg_match($regex, $username);
            $toSearch = $byUsername ? 'username' : 'id'; 
            // $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
            //             ->join('intelligence_indicators AS intInd', 'intInd.id', '=',
            //                 'bridge_table.intelligence_indicator_id')
            //             ->join('intelligences AS ints', 'ints.id', '=', 'intInd.intelligence_id')
            //             ->join(DB::raw("(SELECT GROUP_CONCAT(inti.description SEPARATOR '--') AS all_desc, 
            //                 inti.id, gur.mini_game_id FROM intelligence_indicators AS inti
            //                 JOIN gu_record_intelligence_ind_desc_styles guri 
            //                 ON guri.intelligence_indicator_id = inti.id 
            //                 JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
            //                 JOIN game_users gu ON gu.id = gur.game_user_id
            //                 WHERE gu.".$toSearch." = ? GROUP BY intelligence_id) AS joinS"), 
            //                 'joinS.id', '=', 'bridge_table.intelligence_indicator_id')
            //             ->addBinding($username)
            //             ->select('bridge_table.percentage_value', 'ints.name AS int_name',
            //                 'joinS.all_desc', 'joinS.mini_game_id')
            //             ->whereRaw('bridge_table.game_user_record_id IN
            //                 (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
            //                 ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
            //             ->get();

            $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
                        ->join('intelligence_indicators AS intInd', 'intInd.id', '=',
                            'bridge_table.intelligence_indicator_id')
                        ->join('intelligences AS ints', 'ints.id', '=', 'intInd.intelligence_id')
                        ->join(DB::raw("(SELECT inti.description, inti.id, gur.mini_game_id 
                            FROM intelligence_indicators AS inti
                            JOIN gu_record_intelligence_ind_desc_styles guri 
                            ON guri.intelligence_indicator_id = inti.id 
                            JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
                            JOIN game_users gu ON gu.id = gur.game_user_id
                            WHERE gu.".$toSearch." = ? GROUP BY inti.id) AS joinS"), 
                            'joinS.id', '=', 'bridge_table.intelligence_indicator_id')
                        ->addBinding($username)
                        ->select('bridge_table.percentage_value', 'ints.name AS int_name',
                            DB::raw('GROUP_CONCAT(joinS.description SEPARATOR "--") AS all_desc'), 
                            'joinS.mini_game_id', DB::raw('SUM(bridge_table.percentage_value) AS total'))
                        ->whereRaw('bridge_table.game_user_record_id IN
                            (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
                            ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
                        ->get();
            
            $user_array = array();
            foreach ($result as $key => $element) {
                $descriptions = $element->all_desc;
                if (strrpos($descriptions, '--') !== false) {
                    $descriptions = explode('--', $descriptions);
                }
                $object = (object) array(
                                        // 'mini_game_id' => $element->mini_game_id,
                                        // 'average' => $element->percentage_value,
                                        'intelligence' => $element->int_name,
                                        'description' => $descriptions,
                                        'total' => $element->total);
                array_push($user_array, $object);
            }

            array_push($result_arr, (object) array($username => $user_array));
        }

        return $result_arr;
    }
}
