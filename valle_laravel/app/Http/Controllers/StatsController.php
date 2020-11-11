<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\GameUser;
use App\GameUserRecord;

class StatsController extends Controller
{
    function getByKnowledgeAreasByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $data=(clone $query)->join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->join('mini_games',function($join){
                    $join->on('game_user_records.mini_game_id','mini_games.id')
                    ->on('game_users.grade_id','mini_games.grade_id');
                })
                ->join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->rightJoin('subjects','subject_mini_game.subject_id','subjects.id')
                ->groupBy('subjects.id')
                ->selectRaw('subjects.name, ROUND(AVG(game_user_records.total_score),2) as average')
                ->orderBy('subjects.name')
                ->get();

        if($type==6){
            $bygrade =$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
            ->join('mini_games','game_user_records.mini_game_id','mini_games.id')
            ->join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
            ->rightJoin('subjects','subject_mini_game.subject_id','subjects.id')
            ->rightJoin('grades','mini_games.grade_id','grades.id')
            ->groupBy('grades.id','subjects.id')
            ->selectRaw('grades.name as grade,subjects.name,ROUND(AVG(game_user_records.total_score),2) as average')
            ->orderBy('grades.id')
            ->orderBy('subjects.name')
            ->get()->groupBy('grade');
            return ["data"=> $data, "dataGrade"=>$bygrade];
        }
        else{
            return ["data"=> $data];
        }
    }

    function getByIntelligencesByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $data=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->rightJoin('intelligence_indicators','gu_record_intelligence_ind_desc_styles.intelligence_indicator_id','intelligence_indicators.id')
        ->rightJoin('intelligences','intelligence_indicators.intelligence_id','intelligences.id')
        ->groupBy('intelligences.id')
        ->selectRaw('intelligences.name, ROUND(AVG(gu_record_intelligence_ind_desc_styles.percentage_value),2) as average')
        ->orderBy('intelligences.name')
        ->get();

        return ["data"=> $data];
    }

    function getByStylesByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $query_styles=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->join('description_styles','gu_record_intelligence_ind_desc_styles.description_style_id','description_styles.id');

        $query_styles_by_user= (clone $query_styles)->groupBy('game_users.id')
        ->selectRaw('game_users.id, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_user');

        $query_styles_by_user_style=(clone $query_styles)->groupBy('description_styles.style_id','game_users.id')
        ->selectRaw('game_users.id as game_user_id, description_styles.style_id as style, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_area');

        $data=DB::table('total_styles_by_user_style')
                ->fromSub($query_styles_by_user_style,'total_styles_by_user_style')
                ->joinSub($query_styles_by_user,'total_styles_by_user','total_styles_by_user_style.game_user_id','total_styles_by_user.id')
                ->join('styles','total_styles_by_user_style.style','styles.id')
                ->groupBy('total_styles_by_user_style.style')
                ->selectRaw('styles.name, ROUND(AVG(total_styles_by_user_style.total_by_area/total_styles_by_user.total_by_user),2)*100 as average')
                ->orderBy('styles.name')
                ->get();

        return ["data"=> $data];
    }

    function getByCompetencesByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $query_styles=(clone $query)->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->join('competences','gu_record_intelligence_ind_desc_styles.competence_id','competences.id')
        ->join('description_styles','gu_record_intelligence_ind_desc_styles.description_style_id','description_styles.id');

        $query_styles_by_user= (clone $query_styles)->groupBy('competence','game_users.id')
        ->selectRaw('gu_record_intelligence_ind_desc_styles.competence_id as competence, game_users.id, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_user');

        $query_styles_by_user_style=(clone $query_styles)->groupBy('competence','description_styles.style_id','game_users.id')
        ->selectRaw('gu_record_intelligence_ind_desc_styles.competence_id as competence, game_users.id as game_user_id, description_styles.style_id as style, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_area');

        $styles=DB::table('total_styles_by_user_style')
                ->fromSub($query_styles_by_user_style,'total_styles_by_user_style')
                ->joinSub($query_styles_by_user,'total_styles_by_user',function($join){
                    $join->on('total_styles_by_user_style.game_user_id','total_styles_by_user.id')
                    ->on('total_styles_by_user_style.competence','total_styles_by_user.competence');
                }
                )
                ->rightJoin('styles','total_styles_by_user_style.style','styles.id')
                ->rightJoin('competences','total_styles_by_user_style.competence','competences.id')
                ->groupBy('competences.id','styles.id')
                ->selectRaw('competences.name as competence,styles.name, ROUND(AVG(total_styles_by_user_style.total_by_area/total_styles_by_user.total_by_user),2)*100 as average')
                ->orderBy('competences.name')
                ->orderBy('styles.name')
                ->get()->groupBy('competence');

        $intelligences=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->join('competences','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->rightJoin('intelligence_indicators','gu_record_intelligence_ind_desc_styles.competence_id','competences.id')
        ->rightJoin('intelligences','intelligence_indicators.intelligence_id','intelligences.id')
        ->groupBy('competences.id','intelligences.id')
        ->selectRaw('competences.name as competence, intelligences.name,ROUND(AVG(gu_record_intelligence_ind_desc_styles.percentage_value),2) as average')
        ->orderBy('competences.name')
        ->orderBy('intelligences.name')
        ->get()->groupBy('competence');

        $data=[];
        foreach ($styles as $key => $value) {
            if($intelligences->has($key)){
                $data[$key] = ["intelligences"=>$intelligences[$key],"styles"=>$value];
            }
            else if(isset($value->name)){
                $data[$key] = ["styles"=>$value];
            }
        }

        return ["data"=> $data];
    }

    function getKnowledgeAreasRecomendationsByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $average_grade_area=(clone $query)->join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->join('mini_games',function($join){
                    $join->on('game_user_records.mini_game_id','mini_games.id')
                    ->on('game_users.grade_id','mini_games.grade_id');
                })
                ->join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->groupBy('mini_games.grade_id','subject_mini_game.subject_id')
                ->selectRaw('mini_games.grade_id,subject_mini_game.subject_id,AVG(game_user_records.total_score) as average');

        $data=DB::table('recomendations_by_grade_area')
                ->fromSub($average_grade_area,'recomendations_by_grade_area')
                ->join('performances',function($join){
                    $join->whereRaw('recomendations_by_grade_area.average BETWEEN performances.min AND performances.max');
                })
                ->join('grades','recomendations_by_grade_area.grade_id','grades.id')
                ->join('subjects','recomendations_by_grade_area.subject_id','subjects.id')
                ->leftJoin('recomendations',function($join) use($type){
                    $join->on('grades.id','recomendations.grade_id')
                    ->on('subjects.id','recomendations.subject_id')
                    ->on('performances.id','recomendations.performance_id')
                    ->where('recomendations.hierarchy_id',$type);
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as subject','subjects.id as subject_id','performances.name as performance','recomendations.recomendation')
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->distinct()
                ->get();

                foreach ($data as $key => $value) {
                    $dbas = (clone $query)->join('game_user_records','game_user_records.game_user_id','game_users.id')
                    ->join('mini_games',function($join){
                        $join->on('game_user_records.mini_game_id','mini_games.id')
                        ->on('game_users.grade_id','mini_games.grade_id');
                    })
                    ->join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                    ->where('mini_games.grade_id',$value->grade_id)
                    ->where('subject_mini_game.subject_id',$value->subject_id)
                    ->select('dba')
                    ->distinct()
                    ->get()
                    ->pluck('dba');
                    $data[$key]->dbas = $dbas;
                }
        return ["recomendation"=> $data->groupBy('grade')];
    }

    function getIntelligencesRecomendationsByLocation($type,$id,$grade=null){
        $query = GetBaseStatsQueryByHierarchy($type,$id,$grade);

        $intelligencesIds=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->rightJoin('intelligence_indicators','gu_record_intelligence_ind_desc_styles.intelligence_indicator_id','intelligence_indicators.id')
        ->rightJoin('intelligences','intelligence_indicators.intelligence_id','intelligences.id')
        ->groupBy('intelligences.id')
        ->selectRaw('intelligences.id, ROUND(AVG(gu_record_intelligence_ind_desc_styles.percentage_value),2) as average')
        ->orderBy('average','desc')
        ->take(3)
        ->get();

        $data=GetIntelligencesRecomendations($intelligencesIds->pluck('id')->toArray());

        foreach ($intelligencesIds as $key => $value) {
            $data[$value->id]['average'] = $value->average;
        }

        return ["recomendation"=> $data];
    }
}
