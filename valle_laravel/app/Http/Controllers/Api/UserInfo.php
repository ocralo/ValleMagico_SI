<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;


use Config;

class UserInfo extends Controller
{
    protected function get($username)
    {
        $regex = '/^[A-Za-z]+[0-9]+/';
        $byUsername = preg_match($regex, $username);
        $toSearch = $byUsername ? 'game_users.username' : 'game_users.id';
        $userInfo = DB::table('game_users')
            ->join('dissability_game_user AS dgu', 'dgu.game_user_id', '=', 'game_users.id')
            ->join('dissabilities AS diss', 'diss.id', '=', 'dgu.dissability_id')
            ->join('grades', 'grades.id', '=', 'game_users.grade_id')
            ->select(
                'game_users.id',
                'game_users.grade_id',
                'diss.id AS dissId',
                'diss.name AS dissName',
                'grades.name AS grade_name'
            )
            ->where($toSearch, $username)
            ->first();
        // $grade_obj = (object) array('id'=>$userInfo->grade_id, 'name'=>$userInfo->grade_name);
        //return $userInfo;
        if (!$userInfo) {
            return "Not user in db";
        }

        $grade_id = $userInfo->grade_id;
        $user_id = $userInfo->id;
        $dissability = (object) array('id' => $userInfo->dissId, 'type' => $userInfo->dissName);

        $locationInfo = DB::table('location_skins AS loc')
            ->join('locations AS locs', 'locs.id', '=', 'loc.location_id')
            ->join('location_skin_map_skin AS lsms', 'lsms.location_skin_id', '=', 'loc.id')
            ->join('map_skins AS ms', 'ms.id', '=', 'lsms.map_skin_id')
            ->join('game_users AS gu', 'gu.map_skin_id', '=', 'ms.id')
            ->select('loc.location_id', 'loc.level', 'locs.name')
            ->where('gu.id', $user_id)
            ->orderBy('lsms.id', 'desc')
            ->get();
        if ($locationInfo->isEmpty()) {
            $location = [];
        } else {
            $location = $locationInfo;
            // $location = (object) array('id' => $locationInfo->location_id, 'level' => $locationInfo->level);
        }

        $avatarInfo = DB::table('avatars AS av')
            ->join('avatar_changes AS ac', 'ac.avatar_id', '=', 'av.id')
            ->join('game_users AS gu', 'gu.id', '=', 'ac.game_user_id')
            ->select(
                'av.gender',
                'av.skin',
                'av.profession',
                'av.age',
                'ac.avatar_name',
                'ac.updated_at'
            )
            ->where('gu.id', $user_id)
            ->orderBy('ac.id', 'desc')
            ->first();
        if (!$avatarInfo) {
            $avatar = [];
        } else {
            $server_obj = (object) array(
                'status' => 1, 'lastdate' => $avatarInfo->updated_at,
                'platform' => ''
            );
            $avatar_obj = (object) array(
                'name' => $avatarInfo->avatar_name, 'gender' => $avatarInfo->gender,
                'skin' => $avatarInfo->skin, 'proffesion' => $avatarInfo->profession,
                'type' => $avatarInfo->age, 'server' => $server_obj
            );
            $avatar = array($avatar_obj);
        }

        $data_intelligences = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
            ->join('game_user_records AS gur', 'gur.id', '=', 'guri.game_user_record_id')
            ->join('mini_games', 'mini_games.id', '=', 'gur.mini_game_id')
            ->select(
                'guri.game_user_record_id AS guri_record',
                'mini_games.id_code',
                'guri.competence_id',
                'gur.errors',
                'gur.repeated_guide',
                'gur.total_score',
                'gur.updated_at',
                'guri.intelligence_indicator_id',
                'guri.description_style_id',
                'guri.percentage_value',
                'guri.vocational_orientation_id'
            )
            ->whereRaw('gur.game_user_id = ? AND gur.id IN
                                        (SELECT MAX(id) FROM game_user_records WHERE game_user_id = ?
                                        GROUP BY mini_game_id)', array($user_id, $user_id))
            ->get();

        $intel_record_ids_array = array(0);
        $intels_array = array();
        $styles_array = array();
        $vocationals_array = array();
        $intel_minigames_array = array();
        foreach ($data_intelligences as $key => $intel) {
            $minigame_progress_obj = (object) array(
                'errors' => $intel->errors,
                'repeatedGuide' => $intel->repeated_guide,
                'total' => $intel->total_score
            );
            $minigame_server_obj = (object) array(
                'status' => 1, 'lastdate' => $intel->updated_at,
                'platform' => ''
            );
            $object_minigame = (object) array(
                'gameid' => $intel->id_code,
                'competence' => $intel->competence_id,
                'server' => $minigame_server_obj,
                'progress' => $minigame_progress_obj
            );
            array_push($intel_minigames_array, $object_minigame);
            array_push($intel_record_ids_array, $intel->guri_record);
            if ($intel->intelligence_indicator_id != null) {
                if (!isset($intels_array[$intel->id_code])) $intels_array[$intel->id_code] = array();
                $intel_obj = (object) array(
                    'intelligence_indicator' => $intel->intelligence_indicator_id,
                    'indicator' => $intel->percentage_value
                );
                array_push($intels_array[$intel->id_code], $intel_obj);
            }
            if ($intel->description_style_id != null) {
                if (!isset($styles_array[$intel->id_code])) $styles_array[$intel->id_code] = array();
                $style_obj = (object) array('style_characteristic' => $intel->description_style_id);
                array_push($styles_array[$intel->id_code], $style_obj);
            }
            if ($intel->vocational_orientation_id != null) {
                if (!isset($vocationals_array[$intel->id_code])) $vocationals_array[$intel->id_code] = array();
                $vocational_obj = (object) array('vocational_indicator' => $intel->vocational_orientation_id);
                array_push($vocationals_array[$intel->id_code], $vocational_obj);
            }
        }
        $intel_record_ids_string = implode(',', $intel_record_ids_array);
        $intel_minigames_array = array_values(array_unique($intel_minigames_array, SORT_REGULAR));

        foreach ($intel_minigames_array as $key => $element) {
            $element->intelligences = isset($intels_array[$element->gameid]) ? $intels_array[$element->gameid] : [];
            $element->styles = isset($styles_array[$element->gameid]) ? $styles_array[$element->gameid] : [];
            $element->vocationals = isset($vocationals_array[$element->gameid]) ? $vocationals_array[$element->gameid] : [];
        }

        $minigames_info = DB::table('game_user_records AS gur')
            ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
            ->select(
                'mg.id_code',
                'gur.errors',
                'gur.repeated_guide',
                'gur.total_score',
                'gur.updated_at',
                'mg.location_id'
            )
            ->whereRaw('gur.game_user_id = ? AND gur.id IN (SELECT MAX(id) FROM
                                game_user_records WHERE game_user_id = ? GROUP BY mini_game_id) AND gur.id
                                NOT IN (' . $intel_record_ids_string . ')', array($user_id, $user_id))
            ->get();

        $mini_games_array = array();
        if (!$minigames_info->isEmpty()) {
            foreach ($minigames_info as $key => $element) {
                $server_obj = (object) array(
                    'status' => 1, 'lastdate' => $element->updated_at,
                    'platform' => ''
                );
                $progress_obj = (object) array(
                    'errors' => $element->errors,
                    'repeatedGuide' => $element->repeated_guide,
                    'total' => $element->total_score
                );
                $minigame_obj = (object) array(
                    'gameid' => $element->id_code,
                    'location' => $element->location_id,
                    'server' => $server_obj, 'progress' => $progress_obj
                );
                array_push($mini_games_array, $minigame_obj);
            }
        }

        $toReturn = array(
            'playerid' => $username, 'grade' => $grade_id, 'disability' => $dissability,
            'minigames' => $mini_games_array, 'intelligenceGames' => $intel_minigames_array,
            'locationspritedata' => $location,
            'avatar' => $avatar
        );

        return $toReturn;
    }

    protected function getByRole($userId)
    {
        $final_array = [];
        $departments_array = [];
        $towns_array = [];
        $headquarters_array = [];
        $institutions_array = [];
        $hq_grades = [];
        $game_users = [];
        $users = [];
        $roles = [];
        $permissions = [];

        $userType_info = DB::table('users')->select('username')->where('id', $userId)->first();
        $userType = $userType_info->username;
        if ($userType === 'admin') {
            $users = DB::table('users')->select('id', 'name', 'username')->where('username', '!=', $userType)->get()->toArray();
            $roles = DB::table('roles')
                ->join('role_permission', 'role_permission.role_id', '=', 'roles.id')
                ->join('permissions', 'permissions.id', '=', 'role_permission.permission_id')
                ->select('roles.id', 'roles.slug', 'roles.name', 'permissions.slug AS slug_permission')
                ->where('roles.name', '!=', $userType)
                ->orderBy('permissions.id')
                ->get()
                ->toArray();
            $permissions = DB::table('permissions')->select('id', 'name', 'desc')->get()->toArray();
        }
        $user_permission = DB::table('permissions AS per')
            ->join('role_permission AS rp', 'rp.permission_id', '=', 'per.id')
            ->join('roles AS rl', 'rl.id', '=', 'rp.role_id')
            ->join('user_role AS ur', 'ur.role_id', '=', 'rl.id')
            ->select('per.*')
            ->where('ur.user_id', $userId)
            ->get()
            ->toArray();

        $location_info = DB::table('users')
            ->join('user_hierarchies AS uh', 'uh.user_id', '=', 'users.id')
            ->join('user_role AS ur', 'ur.user_id', '=', 'users.id')
            ->join('roles AS rl', 'rl.id', '=', 'ur.role_id')
            ->join('destiny_hierarchies AS dh', 'dh.id', '=', 'rl.destiny_hierarchy_id')
            ->select('dh.table_name', 'uh.destiny_hierarchy_id')
            ->where('users.id', $userId)
            ->get();


        $role = DB::table('user_role')
        ->where('user_id',$userId)
        ->select('role_id')
        ->first()->role_id;

        $hierarchies = DB::table('user_hierarchies')
        ->select('destiny_hierarchy_id')
        ->where('user_id',$userId)
        ->pluck('destiny_hierarchy_id')->toArray();

        $charGroups =  $this->getGradeCharactersByRole($role,$hierarchies);
        $charStudents = $this->getStudentCharactersByRole($role,$hierarchies);

        $final_array = array(
            'departments' => $departments_array, 'towns' => $towns_array,
            'institutions' => $institutions_array, 'headquarters' => $headquarters_array,
            'hq_grades' => $hq_grades, 'game_users' => $game_users, 'users' => $users,
            'roles' => $roles, 'permissions' => $permissions, 'user_permissions' => $user_permission,
            'charGroups'=>$charGroups, 'charStudents'=>$charStudents
        );

        return $final_array;
    }
    protected function getDeparmentsByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        if($role->role_id>2){
            return "You are not allowed";
        }
        else if(strlen($request->input('textForFilter'))==0){
            $departments = DB::table($ol.'.departments')
            ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
            ->orderBy($ol.'.departments.name')
            ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
            return $departments;
        }else{
            $departments = DB::table($ol.'.departments')
            ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
            ->where($ol.'.departments.name','LIKE','%'.$request->input('textForFilter').'%')
            ->orderBy($ol.'.departments.name')
            ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
            return $departments;
        }
    }
    protected function getTownsByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        if($role->role_id>3){
            return "You are not allowed";
        }
        else{

            if(strlen($request->input('textForFilter'))==0){

                switch ($role->role_id) {
                    case 3:
                        $towns = DB::table($ol.'.towns')
                        ->orderBy($ol.'.towns.name')
                        ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                        break;
                    case 2:
                        $towns = DB::table($ol.'.towns')
                        ->join($ol.'.departments',$ol.'.departments.id','=',$ol.'.towns.department_id')
                        ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->select($ol.'.towns.name as name',$ol.'.towns.id as id')
                        ->orderBy($ol.'.towns.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                        break;
                    case 1:
                        $towns = DB::table($ol.'.towns')
                        ->join($ol.'.departments',$ol.'.departments.id','=',$ol.'.towns.department_id')
                        ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->select($ol.'.towns.name as name',$ol.'.towns.id as id')
                        ->orderBy($ol.'.towns.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                     break;

                    default:
                        # code...
                        break;
                }

            }else{
                switch ($role->role_id) {
                    case 3:
                        $towns = DB::table($ol.'.towns')
                        ->orderBy($ol.'.towns.name')
                        ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                        break;
                    case 2:
                        $towns = DB::table($ol.'.towns')
                        ->join($ol.'.departments',$ol.'.departments.id','=',$ol.'.towns.department_id')
                        ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->select($ol.'.towns.name as name',$ol.'.towns.id as id')
                        ->orderBy($ol.'.towns.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                        break;
                    case 1:
                        $towns = DB::table($ol.'.towns')
                        ->join($ol.'.departments',$ol.'.departments.id','=',$ol.'.towns.department_id')
                        ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->select($ol.'.towns.name as name',$ol.'.towns.id as id')
                        ->orderBy($ol.'.towns.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $towns;
                     break;

                    default:
                        # code...
                        break;
                }
            }
        }
    }
    protected function getInstitutionsByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        if($role->role_id>5){
            return "You are not allowed";
        }
        else{
            if(strlen($request->input('textForFilter'))==0){
                switch ($role->role_id) {
                    case 5:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.institutions.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 4:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.institutions.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 3:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 2:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 1:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                    break;
                    default:
                        # code...
                        break;
                }
            }
            else{
                switch ($role->role_id) {
                    case 5:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.institutions.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.institutions.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%','OR')
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 4:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.institutions.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.institutions.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%','OR')
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 3:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.institutions.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%','OR')
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 2:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.institutions.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%','OR')
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                        break;
                    case 1:
                        $institutions = DB::table($ol.'.institutions')
                        ->join($ol.'.headquarters',$ol.'.headquarters.institution_id','=',$ol.'.institutions.id')
                        ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                        ->select(DB::raw('CONCAT('.$ol.'.institutions.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.institutions.id as id' )
                        ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                        ->where($ol.'.institutions.name','LIKE','%'.$request->input('textForFilter').'%')
                        ->where($ol.'.towns.name','LIKE','%'.$request->input('textForFilter').'%','OR')
                        ->groupBy($ol.'.towns.id',$ol.'.institutions.id')
                        ->orderBy($ol.'.institutions.name')
                        ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                        return $institutions;
                    break;
                    default:
                        # code...
                        break;
                }
            }
        }
    }
    protected function getHeadquartersByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        if(strlen($request->input('textForFilter'))==0){
            switch ($role->role_id) {
                case 6:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 5:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 4:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.institution_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 3:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 2:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 1:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;

                default:
                    # code...
                    break;
            }
        }
        else{
            switch ($role->role_id) {
                case 6:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 5:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 4:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.headquarters.institution_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 3:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 2:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;
                case 1:
                    $headquarters = DB::table($ol.'.headquarters')
                    ->join($ol.'.towns',$ol.'.headquarters.town_id','=',$ol.'.towns.id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.name, " (",'.$ol.'.towns.name,")") as name'), $ol.'.headquarters.id as id' )
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.headquarters.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $headquarters;
                    break;

                default:
                    # code...
                    break;
            }
        }
    }
    protected function getGradesByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        $hq_grades=null;
        if(strlen($request->input('textForFilter'))==0){
            switch ($role->role_id) {
                case 6:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->where('grades.id', $hierarchies[1]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;
                 case 5:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 4:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.institution_id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 3:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.institutions',$ol.'.institutions.id','=',$ol.'.headquarters.institution_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.towns.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 2:
                  $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 1:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE',$request->input('initialChar').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                default:
                    # code...
                    break;
            }
        }
        else{
            switch ($role->role_id) {
                case 6:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->where('grades.id', $hierarchies[1]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;
                 case 5:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 4:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.headquarters.institution_id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 3:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.institutions',$ol.'.institutions.id','=',$ol.'.headquarters.institution_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->where($ol.'.towns.id', $hierarchies[0]->destiny_hierarchy_id)
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 2:
                  $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                 case 1:
                    $hq_grades = DB::table('grades')
                    ->join('game_users','game_users.grade_id','=','grades.id')
                    ->join($ol.'.headquarters', function($join) use($request,$ol){
                        $join->on($ol.'.headquarters.id','=','game_users.headquarter_id')
                        ->where($ol.'.headquarters.name','LIKE','%'.$request->input('textForFilter').'%');
                    })
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::raw('CONCAT('.$ol.'.headquarters.id,"/",grades.id) as id'),DB::raw('CONCAT('.$ol.'.headquarters.name," (",'.$ol.'.towns.name,") - ",UCASE(grades.name)) as name'))
                    ->groupBy($ol.'.headquarters.id','grades.id')
                    ->orderBy($ol.'.headquarters.id')
                    ->orderBy('grades.id')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                 break;

                default:
                    # code...
                    break;
            }
        }

        $toReturn = $hq_grades;
        return $toReturn;
    }
    protected function getStudentsByRole(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $user = Auth::user();
        $role = DB::table('user_role')
        ->where('user_id',$user->id)
        ->first();

        $hierarchies = DB::table('user_hierarchies')
        ->where('user_id',$user->id)
        ->get();

        if(strlen($request->input('textForFilter'))==0){
            if(strlen($request->input('initialChar'))==0){
                return response('No initialChar Provided',400);
            }
            switch ($role->role_id) {
                case 6:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.grade_id','=',$hierarchies[1]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 5:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 4:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.institution_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 3:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.town_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 2:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 1:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE',$request->input('initialChar').'%')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;

                default:
                    $students = DB::table($ol.'.departments')
                    ->where($ol.'.departments.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where($ol.'.departments.name','LIKE','%'.$request->input('textForFilter').'%')
                    ->orderBy($ol.'.departments.name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
            }
        }
        else{
            switch ($role->role_id) {
                case 6:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.grade_id','=',$hierarchies[1]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 5:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 4:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.institution_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 3:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.headquarters.town_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 2:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
                case 1:
                    $students = DB::table('game_users')
                    ->join($ol.'.headquarters',$ol.'.headquarters.id','=','game_users.headquarter_id')
                    ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                    ->select(DB::RAW('CONCAT(game_users.first_name," ",game_users.second_name," ",game_users.first_surname," ",game_users.second_surname," ") as name'),'game_users.id as id')
                    ->where($ol.'.towns.department_id','=',$hierarchies[0]->destiny_hierarchy_id)
                    ->where('game_users.first_name','LIKE','%'.$request->input('textForFilter').'%')
                    ->where('game_users.second_name','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.first_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.second_surname','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where('game_users.username','LIKE','%'.$request->input('textForFilter').'%','OR')
                    ->where(DB::RAW('CONCAT(game_users.first_name, game_users.second_name,game_users.first_surname,game_users.second_surname)'),'LIKE','%'.preg_replace('/\s+/','',$request->input('textForFilter')).'%','OR')
                    ->orderBy('name')
                    ->paginate($request->input('pagination.perPage'),['*'],'page', $request->input('pagination.page'));
                    return $students;
                    break;
            }
        }
    }

    private function getGradeCharactersByRole($role,$hierarchies){
        $ol = env('OPEN_LOCATION_DB');

        $char_grades=null;
        switch ($role) {
            case 6:
                $char_grades = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                  ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                  ->where($ol.'.headquarters.id',$hierarchies[0])
                  ->where('grades.id',$hierarchies[1])
                  ->groupBy($ol.'.headquarters.id','grades.id')
                  ->orderBy($ol.'.headquarters.name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 5:
                $char_grades = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                  ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                  ->where($ol.'.headquarters.id',$hierarchies[0])
                  ->groupBy($ol.'.headquarters.id','grades.id')
                  ->orderBy($ol.'.headquarters.name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 4:
                $char_grades = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                  ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                  ->where($ol.'.headquarters.institution_id',$hierarchies[0])
                  ->groupBy($ol.'.headquarters.id','grades.id')
                  ->orderBy($ol.'.headquarters.name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 3:
                $char_grades = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                  ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                  ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                  ->where($ol.'.towns.id',$hierarchies[0])
                  ->groupBy($ol.'.headquarters.id','grades.id')
                  ->orderBy($ol.'.headquarters.name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
             case 2:
              $char_grades = DB::table('grades')
                ->join('game_users','game_users.grade_id','=','grades.id')
                ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                ->where($ol.'.towns.department_id',$hierarchies[0])
                ->groupBy($ol.'.headquarters.id','grades.id')
                ->orderBy($ol.'.headquarters.name')
                ->distinct()
                ->pluck('c')->toArray();
             break;

             case 1:
                $char_grades = DB::table('grades')
                ->join('game_users','game_users.grade_id','=','grades.id')
                ->join($ol.'.headquarters', $ol.'.headquarters.id','=','game_users.headquarter_id')
                ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                ->select(DB::raw('LEFT('.$ol.'.headquarters.name, 1) as c'))
                ->groupBy($ol.'.headquarters.id','grades.id')
                ->orderBy($ol.'.headquarters.name')
                ->distinct()
                ->pluck('c')->toArray();
             break;

            default:
                # code...
                break;
        }
        return $char_grades;
    }
    protected function getStudentCharactersByRole($role,$hierarchies){
        $ol = env('OPEN_LOCATION_DB');
        $char_students=null;
        switch ($role) {
            case 6:
                $char_students = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters','game_users.headquarter_id',$ol.'.headquarters.id')
                  ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                  ->where($ol.'.headquarters.id',$hierarchies[0])
                  ->where('grades.id',$hierarchies[1])
                  ->orderBy('game_users.first_name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 5:
                $char_students = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters','game_users.headquarter_id',$ol.'.headquarters.id')
                  ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                  ->where($ol.'.headquarters.id',$hierarchies[0])
                  ->orderBy('game_users.first_name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 4:
                $char_students = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters','game_users.headquarter_id',$ol.'.headquarters.id')
                  ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                  ->where($ol.'.headquarters.town_id',$hierarchies[0])
                  ->orderBy('game_users.first_name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
            case 3:
                $char_students = DB::table('grades')
                  ->join('game_users','game_users.grade_id','=','grades.id')
                  ->join($ol.'.headquarters','game_users.headquarter_id',$ol.'.headquarters.id')
                  ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                  ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                  ->where($ol.'.towns.id',$hierarchies[0])
                  ->orderBy('game_users.first_name')
                  ->distinct()
                  ->pluck('c')->toArray();
               break;
             case 2:
              $char_students = DB::table('grades')
                ->join('game_users','game_users.grade_id','=','grades.id')
                ->join($ol.'.headquarters','game_users.headquarter_id',$ol.'.headquarters.id')
                ->join($ol.'.towns',$ol.'.towns.id','=',$ol.'.headquarters.town_id')
                ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                ->where($ol.'.towns.department_id',$hierarchies[0])
                ->orderBy('game_users.first_name')
                ->distinct()
                ->pluck('c')->toArray();
             break;

             case 1:
                $char_students = DB::table('grades')
                ->join('game_users','game_users.grade_id','=','grades.id')
                ->select(DB::raw('LEFT(game_users.first_name, 1) as c'))
                ->orderBy('game_users.first_name')
                ->distinct()
                ->pluck('c')->toArray();
             break;

            default:
                # code...
                break;
        }
        return $char_students;
    }


    protected function unique_array_by_id($array)
    {
        $array_to_return = array();
        foreach ($array as $key => $element) {
            if (!in_array($element, $array_to_return)) array_push($array_to_return, $element);
        }
        return $array_to_return;
    }

    protected function insertStudentsInArray($ids_hq_grade)
    {-
        $array = [];
        $students_db = DB::table('game_users AS gu')
            ->join('grades AS gr', 'gr.id', '=', 'gu.grade_id')
            ->select('gu.username', 'gu.id', 'gu.first_name', 'gu.second_name', 'gu.first_surname', 'gu.second_surname', 'gu.grade_id', 'gr.name AS grade_name')
            ->where('headquarter_id', $ids_hq_grade[0])
            ->where('grade_id', $ids_hq_grade[1])
            ->get()
            ->toArray();

        foreach ($students_db as $key => $element) {
            $n1 = $element->first_name ?? '';
            $n2 = $element->second_name ?? '';
            $s1 = $element->first_surname ?? '';
            $s2 = $element->second_surname ?? '';
            $full_name = $n1 . ' ' . $n2 . ' ' . $s1 . ' ' . $s2;
            $game_user_to_push = (object) array('id' => $element->id, 'name' => $full_name, 'grade' => $element->grade_id, 'grade_name' => $element->grade_name);
            array_push($array, $game_user_to_push);
        }

        return $array;
    }




    //Fix to Old code and performance issues


}
