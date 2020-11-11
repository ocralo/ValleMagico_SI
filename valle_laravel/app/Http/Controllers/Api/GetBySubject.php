<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Http\Controllers\Controller;

class GetBySubject extends Controller
{
    /**
     * Receives a subject id and returns the average of score for that subject First looks for the 
     * info in Redis, if that's not found then looks for the info in the database and saves it in Redis.
     */
    protected function get($id) {
        // if (Redis::get('subject-'.$id)) {
        //     $result = json_decode(Redis::get('subject-'.$id));
        // } else {
            $result = DB::table('game_user_records')
                        ->join('mini_games', 'game_user_records.mini_game_id', '=', 'mini_games.id')
                        ->join('subject_mini_game', 'mini_games.id', '=', 'subject_mini_game.mini_game_id')
                        ->join('subjects', 'subject_mini_game.subject_id', '=', 'subjects.id')
                        ->select(DB::raw('ROUND(AVG(game_user_records.total_score),1) as average, subjects.name'))
                        ->where('subjects.id', $id)
                        ->groupBy('subjects.name')
                        ->get();

        //     !empty($result[0]) ? Redis::set('subject-'.$id, $result->toJson()) : null;
        // }

        if (!empty($result[0])) {
            http_response_code(200);
            return $result;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }
}
