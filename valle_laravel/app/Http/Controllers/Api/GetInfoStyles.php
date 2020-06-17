<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class GetInfoStyles extends Controller
{
    protected function getOne($username) {
        // if (Redis::get('intelligences-'.$username)) {
        //     $result = json_decode(Redis::get('intelligences-'.$username));
        // } else {
            $toReturn = array();
            $regex = '/^[A-Za-z]+[0-9]+/';
            $byUsername = preg_match($regex, $username);
            $toSearch = $byUsername ? 'username' : 'id';

            $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
                        ->join('description_styles AS descSt', 'descSt.id', '=',
                            'bridge_table.description_style_id')
                        ->join('styles AS stl', 'stl.id', '=', 'descSt.style_id')
                        ->join(DB::raw("(SELECT GROUP_CONCAT(descStl.description SEPARATOR '--') AS all_desc, 
                            COUNT(*) AS quantity, descStl.id, gur.mini_game_id FROM description_styles AS descStl
                            JOIN gu_record_intelligence_ind_desc_styles guri 
                            ON guri.description_style_id = descStl.id 
                            JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
                            JOIN game_users gu ON gu.id = gur.game_user_id
                            WHERE gu.".$toSearch." = ? GROUP BY descStl.style_id) AS joinS"),
                            'joinS.id', '=', 'bridge_table.description_style_id')
                        ->addBinding($username)
                        ->select('joinS.quantity', 'stl.name AS style_name',
                            'stl.description AS extra', 'joinS.all_desc')
                        ->whereRaw('bridge_table.game_user_record_id IN
                            (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
                            ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
                        ->groupBy('stl.id')
                        ->get();

            foreach ($result as $key => $element) {
                $descriptions = $element->all_desc;
                if (strrpos($descriptions, '--') !== false) {
                    $descriptions = explode('--', $descriptions);
                }
                $object = (object) array('average' => $element->quantity,
                                        'name' => $element->style_name,
                                        'extra_name' => $element->extra,
                                        'description' => $descriptions);
                array_push($toReturn, $object);
            }
        
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
            $result = DB::table('gu_record_intelligence_ind_desc_styles AS bridge_table')
                        ->join('description_styles AS descSt', 'descSt.id', '=',
                            'bridge_table.description_style_id')
                        ->join('styles AS stl', 'stl.id', '=', 'descSt.style_id')
                        ->join(DB::raw("(SELECT GROUP_CONCAT(descStl.description SEPARATOR '--') AS all_desc, 
                            COUNT(*) AS quantity, descStl.id, gur.mini_game_id FROM description_styles AS descStl
                            JOIN gu_record_intelligence_ind_desc_styles guri 
                            ON guri.description_style_id = descStl.id 
                            JOIN game_user_records gur ON gur.id = guri.game_user_record_id 
                            JOIN game_users gu ON gu.id = gur.game_user_id
                            WHERE gu.".$toSearch." = ? GROUP BY descStl.style_id) AS joinS"), 
                            'joinS.id', '=', 'bridge_table.description_style_id')
                        ->addBinding($username)
                        ->select('joinS.quantity', 'stl.name AS style_name',
                            'stl.description AS extra', 'joinS.all_desc')
                        ->whereRaw('bridge_table.game_user_record_id IN
                            (SELECT gur.id FROM game_user_records AS gur JOIN game_users gu
                            ON gu.id = gur.game_user_id WHERE gu.'.$toSearch.' = ?)', array($username))
                        ->groupBy('stl.id')
                        ->get();

            $user_array = array();
            foreach ($result as $key => $element) {
                $descriptions = $element->all_desc;
                if (strrpos($descriptions, '--') !== false) {
                    $descriptions = explode('--', $descriptions);
                }
                $object = (object) array('average' => $element->quantity,
                                        'name' => $element->style_name,
                                        'extra_name' => $element->extra,
                                        'description' => $descriptions);
                array_push($user_array, $object);
            }

            array_push($result_arr, (object) array($username => $user_array));
        }

        return $result_arr;
    }
}