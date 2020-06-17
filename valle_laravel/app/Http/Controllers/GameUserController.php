<?php

namespace App\Http\Controllers;

use App\GameUser;
use App\GameUserRecord;
use Illuminate\Http\Request;

class GameUserController extends Controller
{
    protected function init($username){
        $result = GameUser::with(['avatar','dissabilities','latest_game_records.minigame.subjects','map_skin.location_skins.location'])
                ->where('username','=',$username)->firstOrFail();

        $response = new \stdClass();
        $response->playerid = $result->id;

        //Dissability will be the first dissability on array
        $response->disability = new \stdClass();
        $userDissability = $result->dissabilities->first();
        $response->disability->id= $userDissability->id;
        $response->disability->type= $userDissability->name;

        //Saved minigames
        $response->minigames=array();
        foreach ($result->latest_game_records as $record) {
            $minigame=new \stdClass();
            $minigame->gameid=$record->minigame->id;
            $minigame->gamegrade='Not implemented Yet';
            $minigame->subjects=array();
            foreach ($record->minigame->subjects as $subject) {
                array_push($minigame->subjects,$subject->name);
            }
            $minigame->level='Not implemented Yet';
            $minigame->location='Not implemented Yet';
            array_push($response->minigames,$minigame);
        }
        //Location Sprite player customization data
        $response->locationspritedata = array();
        foreach ($result->map_skin->location_skins as $spriteData) {
            $location=new \stdClass();
            $location->id=$spriteData->location->id;
            $location->name=$spriteData->location->name;;
            $location->level=$spriteData->skin;
            array_push($response->locationspritedata,$location);
        }
        //Avatar
        $response->avatar = $result->avatar;
        
        return response()->json($response);
    }
    protected function update(Request $request){
        dd($request);
    }
}
