<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;

use App\Http\Controllers\Controller;
use Config;

class GetByLocationType extends Controller
{
    /**
     * Receives a location type that can be department, town or institution and the id of the location to
     * return the average of score for every subject segmented by the location type. First looks for the
     * info in Redis, if that's not found then uses the open_location api to get the info and saves it in 
     * Redis.
     */
    protected function get($locationType, $id) {
        // if (Redis::get($locationType.'-'.$id)) {
        //     $result = json_decode(Redis::get($locationType.'-'.$id));
        // } else {
            $headquarters = getHeadquarters($locationType, $id);
            $result = DB::table('game_user_records')
                    ->join('game_users', 'game_user_records.game_user_id', '=', 'game_users.id')
                    ->join('mini_games', 'game_user_records.mini_game_id', '=', 'mini_games.id')
                    ->join('subject_mini_game', 'mini_games.id', '=', 'subject_mini_game.mini_game_id')
                    ->join('subjects', 'subject_mini_game.subject_id', '=', 'subjects.id')
                    ->select(DB::raw('ROUND(AVG(game_user_records.total_score),1) as average, subjects.name'))
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    ->groupBy('subjects.name')
                    ->get();

            // !empty($result[0]) ? Redis::set($locationType.'-'.$id, $result->toJson()) : null;
        // }

        if (!empty($result[0])) {
            http_response_code(200);
            return $result;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getBySubject($locationType, $id, $subject) {
        $headquarters = getHeadquarters($locationType, $id);
        $result = DB::table('game_user_records')
                ->join('game_users', 'game_user_records.game_user_id', '=', 'game_users.id')
                ->join('mini_games', 'game_user_records.mini_game_id', '=', 'mini_games.id')
                ->join('subject_mini_game', 'mini_games.id', '=', 'subject_mini_game.mini_game_id')
                ->join('subjects', 'subject_mini_game.subject_id', '=', 'subjects.id')
                ->select(DB::raw('ROUND(AVG(game_user_records.total_score),1) as average, mini_games.name'))
                ->whereIn('game_users.headquarter_id', $headquarters)
                ->where('subjects.id', $subject)
                ->groupBy('mini_games.name')
                ->get();

        if (!empty($result[0])) {
            http_response_code(200);
            return $result;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getIntelligences($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                    ->join('game_user_records', 'game_user_records.id', '=', 'guri.game_user_record_id')
                    ->join('game_users', 'game_users.id', '=', 'game_user_records.game_user_id')
                    ->join('intelligence_indicators AS intin', 'intin.id', '=', 'guri.intelligence_indicator_id')
                    ->join('intelligences', 'intelligences.id', '=', 'intin.intelligence_id')
                    // ->select(DB::raw("ROUND(AVG(guri.percentage_value),1) as average, 
                    //     GROUP_CONCAT(intin.description SEPARATOR '--') AS all_desc, intelligences.name"))
                    ->select(DB::raw("guri.percentage_value, intin.description, intelligences.name, game_users.id"))
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    // ->groupBy('intelligences.name')
                    ->get();

        $toReturn = getGlobalIntelligencesInfo($result);

        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getStyles($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                    ->join('game_user_records', 'game_user_records.id', '=', 'guri.game_user_record_id')
                    ->join('game_users', 'game_users.id', '=', 'game_user_records.game_user_id')
                    ->join('description_styles AS descSt', 'descSt.id', '=', 'guri.description_style_id')
                    ->join('styles', 'styles.id', '=', 'descSt.style_id')
                    // ->select(DB::raw("COUNT(styles.id) as average, 
                    //     GROUP_CONCAT(descSt.description SEPARATOR '--') AS all_desc, styles.name,
                    //     styles.description AS extra_name"))
                    ->select('styles.id', 'descSt.description', 'styles.name', 'styles.description AS extra_name',
                        'game_users.id')
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    // ->groupBy('styles.name')
                    ->get();

        $toReturn = getGlobalStylesInfo($result);

        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getIntelligencesByCompetence($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                    ->join('game_user_records', 'game_user_records.id', '=', 'guri.game_user_record_id')
                    ->join('game_users', 'game_users.id', '=', 'game_user_records.game_user_id')
                    ->join('intelligence_indicators AS intin', 'intin.id', '=', 'guri.intelligence_indicator_id')
                    ->join('intelligences', 'intelligences.id', '=', 'intin.intelligence_id')
                    ->join('competences', 'competences.id', '=', 'guri.competence_id')
                    // ->select(DB::raw("ROUND(AVG(guri.percentage_value),1) as average, 
                    //     GROUP_CONCAT(intin.description SEPARATOR '--') AS all_desc, intelligences.name,
                    //     competences.id AS competence"))
                    ->select(DB::raw("guri.percentage_value, intin.description, intelligences.name, game_users.id,
                        competences.id AS competence"))
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    // ->groupBy('intelligences.name', 'competences.name')
                    ->get();

        $toReturn = getGlobalIntelligencesByCompetenceInfo($result);

        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getStylesByCompetence($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                    ->join('game_user_records', 'game_user_records.id', '=', 'guri.game_user_record_id')
                    ->join('game_users', 'game_users.id', '=', 'game_user_records.game_user_id')
                    ->join('description_styles AS descSt', 'descSt.id', '=', 'guri.description_style_id')
                    ->join('styles', 'styles.id', '=', 'descSt.style_id')
                    ->join('competences', 'competences.id', '=', 'guri.competence_id')
                    // ->select(DB::raw("COUNT(styles.id) as average, 
                    //     GROUP_CONCAT(descSt.description SEPARATOR '--') AS all_desc, 
                    //     competences.id AS competence, styles.name, styles.description AS extra_name"))
                    ->select('styles.id', 'descSt.description', 'styles.name', 'styles.description AS extra_name',
                        'game_users.id', 'competences.id AS competence')
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    // ->groupBy('competences.name', 'styles.name')
                    ->get();

        return getGlobalStylesByCompetenceInfo($result);

        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getScoreByMGGrade($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $db_info = DB::table('game_user_records AS gur')
                        ->join('mini_games AS mg', 'mg.id', '=', 'gur.mini_game_id')
                        ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                        ->join('grades', 'grades.id', '=', 'mg.grade_id')
                        ->select(DB::raw('ROUND(AVG(gur.total_score),1) as average'), 'grades.name',
                                        'grades.id AS grade_id')
                        ->whereIn('gu.headquarter_id', $headquarters)
                        ->groupBy('mg.grade_id')
                        ->get();

        if (!empty($db_info[0])) {
            http_response_code(200);
            return $db_info;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getVocationals($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);

        $result = DB::table('gu_record_intelligence_ind_desc_styles AS guri')
                    ->join('game_user_records', 'guri.game_user_record_id', '=', 'game_user_records.id')
                    ->join('game_users', 'game_users.id', '=', 'game_user_records.game_user_id')
                    ->join('vocationals_orientations AS vo', 'vo.id', '=', 'guri.vocational_orientation_id')
                    // ->select(DB::raw("COUNT(styles.id) as average, 
                    //     GROUP_CONCAT(descSt.description SEPARATOR '--') AS all_desc, styles.name,
                    //     styles.description AS extra_name"))
                    ->select('vo.id', 'vo.name', 'game_users.id AS game_user', 'guri.id AS guri')
                    ->whereIn('game_users.headquarter_id', $headquarters)
                    // ->groupBy('styles.name')
                    ->get();

        $toReturn = getGlobalVocationalsInfo($result);

        if (!empty($result[0])) {
            http_response_code(200);
            return $toReturn;
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "No info found."));
        }
    }

    protected function getRecomendationsAndDbas($locationType, $id) {
        $headquarters = getHeadquarters($locationType, $id);
        $locationTypeId = 0;
        switch ($locationType) {
            case 'department': $locationTypeId = 1; break;
            case 'town': $locationTypeId = 2; break;
            case 'institution': $locationTypeId = 3; break;
        }

        $result_mg = DB::table('game_user_records AS gur')
                        ->join('game_users AS gu', 'gu.id', '=', 'gur.game_user_id')
                        ->join('mini_games AS mg', function($join) {
                            $join->on('mg.id', '=', 'gur.mini_game_id');
                            $join->on('mg.grade_id', '=', 'gu.grade_id');
                        })
                        ->join('subject_mini_game AS smg', 'smg.mini_game_id', '=', 'mg.id')
                        ->join('subjects AS sub', 'sub.id', '=', 'smg.subject_id')
                        ->select('gur.total_score', 'gu.grade_id', 'smg.subject_id', 'smg.dba', 
                            'gu.id AS game_user', 'sub.name')
                        ->whereIn('gu.headquarter_id', $headquarters)
                        ->get();

        $groupBySubAndGrade = groupRecomendationsBySubAndGrade($result_mg);
        $toReturn = $groupBySubAndGrade;

        foreach ($groupBySubAndGrade as $key_sg => $element) {
            foreach ($element as $key => $value) {
                $value = (object) $value;
                $result = DB::table('performances AS per')
                        ->join('recomendations AS rec', 'rec.performance_id', '=', 'per.id')
                        ->select('per.name AS perf', 'rec.recomendation', 'rec.id')
                        ->where('per.min', '<=', ceil($value->average))
                        ->where('per.max', '>=', ceil($value->average))
                        ->where('rec.grade_id', $key_sg)
                        ->where('rec.subject_id', $value->subject_id)
                        ->where('rec.hierarchy_id', $locationTypeId)
                        ->get();

                if (isset($result[0])) {
                    $toReturn[$key_sg][$key]['performance'] = $result[0]->perf;
                    $toReturn[$key_sg][$key]['recomendation'] = $result[0]->recomendation;
                }
                if ($toReturn[$key_sg][$key]['subject_id'] === 4) { // 4 is the id for the subject "competencias ciudadanas"
                    unset($toReturn[$key_sg][$key]);
                }
            }
            $toReturn[$key_sg] = array_values($toReturn[$key_sg]);
        }

        return $toReturn;
    }
}

