<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\GameUser;
use App\GameUserRecord;
use App\AvatarChanges;
use App\miniGame;
use App\LocationSkinMapSkin;
use App\GuRecordIntelligenceIndDescStyle;
use App\Http\Controllers\Controller;

class SaveRecords extends Controller
{
    /**
     * Receives a JSON with the necessary info to save the progress of a student that has played or is
     * playing a particular minigame.
     */
    protected function save(Request $request)
    {
        $original = $request->all();
        $username = $request->get('playerid');
        $minigames = $request->get('minigames');
        $avatars = $request->get('avatar');
        $locations = $request->get('locationspritedata');
        $intelligences_games = $request->get('intelligenceGames');
        date_default_timezone_set('America/Bogota');

        $correct_game_user = [];
        $correct_avatar = [];
        $user = GameUser::where('username', $username)->first();

        if ($user === null) {
            http_response_code(400);
            return json_encode(array("message" => "There was an error saving the info.", "error" => "The user doesn't exist."));
        }

        $userId = $user->id;

        /**
         * Get and save the id from map_skins table related with the info received into an array, to later
         * check if it is the same in the game_user table and update it if is necessary.
         */
        if ($locations !== null && isset($locations[0])) {
            // Check if location skins exist
            foreach ($locations as $key => $location) {
                $location = (object) $location;
                $locations_gotten = DB::table('location_skins')
                    ->where([
                        ['location_skins.location_id', '=', $location->location_id],
                        ['location_skins.level', '=', $location->level],
                    ])
                    ->get();
                if ($locations_gotten->isEmpty()) return json_encode(array("message" => "There was an error.", "error" => "The location skin doesn't exist."));
            }

            // Check if the map skin linked to the user is the same that the map skin sent
            $location_ids_user = [];
            $locations_from_map = DB::table('location_skin_map_skin')
                ->select('location_skin_id')
                ->where('map_skin_id', $user->map_skin_id)
                ->get();
            foreach ($locations_from_map as $key => $loc) {
                array_push($location_ids_user, $loc->location_skin_id);
            }

            $location_ids_from_sent = [];
            foreach ($locations as $key => $location) {
                $location = (object) $location;
                $locations_from_sent = DB::table('location_skins')
                    ->select('id')
                    ->where([
                        ['location_id', '=', $location->location_id],
                        ['level', '=', $location->level]
                    ])
                    ->first();
                array_push($location_ids_from_sent, $locations_from_sent->id);
            }
            if ($location_ids_user != $location_ids_from_sent) {
                $id_map_skins = [];
                $final_map_skin = '';
                foreach ($locations as $key => $location) {
                    $location = (object) $location;

                    $map_skin_id_user_db = DB::table('map_skins')
                        ->join('location_skin_map_skin', 'map_skins.id', '=', 'location_skin_map_skin.map_skin_id')
                        ->join('location_skins', 'location_skin_map_skin.location_skin_id', '=', 'location_skins.id')
                        ->select('map_skins.id AS map_id', 'location_skins.id AS loc_id')
                        ->where([
                            ['location_skins.location_id', '=', $location->location_id],
                            ['location_skins.level', '=', $location->level],
                        ])
                        ->distinct('map_skins.id')
                        ->get();

                    if ($map_skin_id_user_db) {
                        foreach ($map_skin_id_user_db as $key => $value) {
                            if (!isset($id_map_skins[$value->map_id])) {
                                $id_map_skins[$value->map_id] = array();
                            }
                            array_push($id_map_skins[$value->map_id], $value->loc_id);
                        }
                    }
                }

                foreach ($id_map_skins as $key => $element) {
                    if ($element === $location_ids_from_sent) $final_map_skin = $key;
                }
                if ($final_map_skin != '') {
                    $update_map_skin = DB::table('game_users')
                        ->where('id', $userId)
                        ->update(['map_skin_id' => $final_map_skin]);
                } else {
                    $new_map_skin = DB::table('map_skins')->insertGetId(['created_at' => now(), 'updated_at' => now()]);
                    if (empty($new_map_skin)) return json_encode(array("message" => "There was an error saving the info.", "error" => "Error saving the map skin."));
                    foreach ($location_ids_from_sent as $key => $loc) {
                        LocationSkinMapSkin::create([
                            'map_skin_id' => $new_map_skin,
                            'location_skin_id' => $loc
                        ]);
                    }
                    $update_map_skin = DB::table('game_users')
                        ->where('id', $userId)
                        ->update(['map_skin_id' => $new_map_skin]);
                }
            }
        }

        $last_avatar_change = DB::table('avatar_changes')
            ->join('avatars', 'avatar_changes.avatar_id', '=', 'avatars.id')
            ->select(
                'avatars.id',
                'avatars.skin',
                'avatars.profession',
                'avatars.gender',
                'avatars.age',
                'avatar_changes.avatar_name'
            )
            ->where('avatar_changes.game_user_id', $userId)
            ->orderBy('avatar_changes.id', 'desc')
            ->limit(1)
            ->first();
        /**
         * Get the id of an avatar and add a new row in the table avatar_changes only if
         * the last avatar change is not the same sent in the JSON.
         */

        if ($avatars !== null && isset($avatars[0])) {

            foreach ($avatars as $key => $avatar) {
                $avatar = (object) $avatar;
                if (
                    isset($avatar->skin) && isset($avatar->gender)
                    && isset($avatar->name)
                ) {
                    if (!$last_avatar_change || ($last_avatar_change->skin !== $avatar->skin ||
                        $last_avatar_change->gender !== $avatar->gender || $last_avatar_change->profession !== $avatar->proffesion ||
                        $last_avatar_change->age !== $avatar->type ||
                        $last_avatar_change->avatar_name !== $avatar->name)) {

                        $avatar_db = DB::table('avatars')
                            ->select('id')
                            ->where([
                                ['skin', '=', $avatar->skin],
                                ['profession', '=', $avatar->proffesion],
                                ['gender', '=', $avatar->gender],
                                ['age', '=', $avatar->type]
                            ])
                            ->first();

                        if ($avatar_db) {
                            AvatarChanges::create([
                                'avatar_name' => $avatar->name,
                                'game_user_id' => $userId,
                                'avatar_id' => $avatar_db->id
                            ]);
                            if ($avatar->server['lastdate'] == '' && $avatar->server['lastdate'] == null) {
                                $avatars[$key]['server'] = (object) array(
                                    'status' => 1,
                                    'lastdate' => date("Y-m-d H:i:s"),
                                    'platform' => ''
                                );
                            }
                        }
                    } else {
                        if ($avatar->server['lastdate'] == '' || $avatar->server['lastdate'] == null) {
                            $avatars[$key]['server'] = (object) array(
                                'status' => 1,
                                'lastdate' => date("Y-m-d H:i:s"),
                                'platform' => ''
                            );
                        }
                    }
                }
            }
            $original['avatar'] = $avatars;
        }

        /**
         * Save the info related to the minigames received in the JSON
         */
        if ($minigames !== null && isset($minigames[0])) {
            foreach ($minigames as $key => $minigame) {
                $minigame = (object) $minigame;
                $minigameById = miniGame::where('id_code', $minigame->gameid)->first();
                if ($minigameById !== null) {
                    $minigameId = $minigameById->id;
                    $progress = (object) $minigame->progress;
                    if (
                        isset($progress) && isset($progress->errors) && isset($progress->repeatedGuide)
                        && isset($progress->total) && ($minigame->server['lastdate'] == ''
                            || $minigame->server['lastdate'] == null)
                    ) {
                        $new_game_user_record = GameUserRecord::create([
                            'errors' => $progress->errors,
                            'repeated_guide' => $progress->repeatedGuide,
                            'total_score' => $progress->total,
                            'mini_game_id' => $minigameId,
                            'game_user_id' => $userId
                        ]);
                        $minigames[$key]['server'] = (object) array(
                            'status' => 1,
                            'lastdate' => date("Y-m-d H:i:s"),
                            'platform' => ''
                        );
                    }
                }
            }
            $original['minigames'] = $minigames;
        }

        // Save info related with games in multiple intelligences
        if ($intelligences_games != null && isset($intelligences_games[0])) {
            foreach ($intelligences_games as $key => $minigame) {
                $minigame = (object) $minigame;
                $minigameById = miniGame::where('id_code', $minigame->gameid)->first();
                if ($minigameById !== null) {
                    $minigameId = $minigameById->id;
                    $progress = (object) $minigame->progress;
                    if (
                        isset($progress) && isset($progress->errors) && isset($progress->repeatedGuide)
                        && isset($progress->total) && isset($minigame->competence)
                        && ($minigame->server['lastdate'] == '' || $minigame->server['lastdate'] == null)
                    ) {
                        $new_game_user_record_id = DB::table('game_user_records')->insertGetId([
                            'errors' => $progress->errors,
                            'repeated_guide' => $progress->repeatedGuide,
                            'total_score' => $progress->total,
                            'mini_game_id' => $minigameId,
                            'game_user_id' => $userId,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                        if (!empty($new_game_user_record_id)) {
                            $intelligences_games[$key]['server'] = (object) array(
                                'status' => 1,
                                'lastdate' => date("Y-m-d H:i:s"),
                                'platform' => ''
                            );
                            $intelligences = $minigame->intelligences;
                            $styles = $minigame->styles;
                            $styles_inserted = array();
                            $vocationals = $minigame->vocations ?? [];
                            if (isset($intelligences[0])) {
                                foreach ($intelligences as $key => $int) {
                                    $int = (object) $int;
                                    $desc_style = NULL;
                                    $vocational_orientation = NULL;
                                    if (isset($styles[0])) {
                                        $index_styles = array_search($int->round, array_column($styles, 'round'));
                                        if ($index_styles !== false) {
                                            $style_obj = (object) $styles[$index_styles];
                                            array_push($styles_inserted, $index_styles);
                                        } else {
                                            $style_obj = (object) array('style_characteristic' => null);
                                        }
                                        $desc_style = $int->round == 0 ? null : $style_obj->style_characteristic;
                                    }
                                    if (isset($vocationals[0])) {
                                        $index_vocationals = array_search($int->round, array_column($vocationals, 'round'));
                                        if ($index_vocationals !== false) {
                                            $vocational_obj = (object) $vocationals[$index_vocationals];
                                        } else {
                                            $vocational_obj = (object) array('vocational_indicator' => null);
                                        }
                                        $vocational_orientation = $vocational_obj->vocational_indicator;
                                    }
                                    $new_record = GuRecordIntelligenceIndDescStyle::create([
                                        'game_user_record_id' => $new_game_user_record_id,
                                        'intelligence_indicator_id' => $int->intelligence_indicator,
                                        'description_style_id' => $desc_style,
                                        'vocational_orientation_id' => $vocational_orientation,
                                        'competence_id' => $minigame->competence,
                                        'percentage_value' => $int->indicator
                                    ]);
                                }
                            } else if (isset($styles[0])) {
                                foreach ($styles as $key => $st) {
                                    if (!in_array($key, $styles_inserted)) {
                                        $new_record = GuRecordIntelligenceIndDescStyle::create([
                                            'game_user_record_id' => $new_game_user_record_id,
                                            'description_style_id' => $st->style_characteristic,
                                            'competence_id' => $minigame->competence,
                                        ]);
                                    }
                                }
                            } else {
                                $new_record = GuRecordIntelligenceIndDescStyle::create([
                                    'game_user_record_id' => $new_game_user_record_id,
                                    'competence_id' => $minigame->competence
                                ]);
                            }
                        }
                    }
                }
            }
            $original['intelligenceGames'] = $intelligences_games;
        }

        /**
         * Send an answer to the request.
         */
        return $original;
        // if ($correct_location) return json_encode($correct_location);
    }
}
