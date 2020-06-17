<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Http\Controllers\Controller;

class GetPlayersPlayed extends Controller
{
    /**
     * Return a JSON with two values, the quantity of players that has played the game and the quantity of
     * players that hasn't played it. First looks for the info in Redis, if that's not found then looks for 
     * the info in the database and saves it in Redis.
     */
    protected function get() {
        // if (Redis::get('playersPlayed')) {
        //     $result = json_decode(Redis::get('playersPlayed'));
        // } else {
            $played = DB::table('game_users')
                        ->join('game_user_records', 'game_users.id', '=', 'game_user_records.game_user_id')
                        ->distinct('game_users.id')
                        ->count();
    
            $notPlayed = DB::table('game_users')
                            ->leftJoin('game_user_records', 'game_users.id', '=', 'game_user_records.game_user_id')
                            ->whereNull('game_user_records.game_user_id')
                            ->distinct('game_users.id')
                            ->count();

            $result = (object) array('played' => $played, 'notPlayed' => $notPlayed);

        //     Redis::set('playersPlayed', json_encode($result));
        // }

        return json_encode($result);
    }
}
