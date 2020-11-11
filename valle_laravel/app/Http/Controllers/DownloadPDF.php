<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use PDF;
use URL;
use Illuminate\Support\Facades\Storage;

/*use App\Http\Controllers\Api\GetByLocationType;
define('__ROOT__', dirname(dirname('GetByLocationType')));
require_once(__ROOT__.'/GetByLocationType.php'); */

class DownloadPDF extends Controller
{
    public function knowledgeAreaProgressByHierarchy(Request $request){
        $ol = env('OPEN_LOCATION_DB');

        $data = $request->only(['locationType','id',/* 'grade', */'graph','name']);
        $locationType =$data['locationType'];
        $id =$data['id'];
        $graph = $data['graph'];
        $name = $data['name'];
        /* if(isset($data['grade'])){
            $grade = $data['grade'];
        }else{
            $grade = null;
        } */
        $grade = null;
        $pos = strpos($id, "/");
        if($pos){
            list($id, $grade) = explode("/", $id);
        }

        $recomendations=null;
        $entity=null;
        switch ($locationType) {
            case 6:
                $entity=DB::table('game_users')
                ->select(DB::raw('CONCAT(first_name," ",second_name," ",first_surname," ",second_surname) as name'))
                ->where('game_users.id',$id)
                ->first();
                $recomendations = DB::table('game_users')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    //$join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where('game_users.id',$id)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;
            case 5:
                $entity=DB::table($ol.'.headquarters')
                ->select($ol.'.headquarters.name as name')
                ->where($ol.'.headquarters.id',$id)
                ->first();
                $recomendations = DB::table($ol.'.headquarters')
                ->Join('game_users','game_users.headquarter_id',$ol.'.headquarters.id')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    $join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where($ol.'.headquarters.id',$id)
                ->where('grades.id',$grade)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;
            case 4:
                $entity=DB::table($ol.'.headquarters')
                ->select($ol.'.headquarters.name as name')
                ->where($ol.'.headquarters.id',$id)
                ->first();
                $recomendations = DB::table($ol.'.headquarters')
                ->Join('game_users','game_users.headquarter_id',$ol.'.headquarters.id')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    $join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where($ol.'.headquarters.id',$id)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;
            case 3:
                $entity=DB::table($ol.'.institutions')
                ->select($ol.'.institutions.name as name')
                ->where($ol.'.institutions.id',$id)
                ->first();
                $recomendations = DB::table($ol.'.institutions')
                ->Join($ol.'.headquarters',$ol.'.headquarters.institution_id',$ol.'.institutions.id')
                ->Join('game_users','game_users.headquarter_id',$ol.'.headquarters.id')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    $join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where($ol.'.institutions.id',$id)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;
            case 2:
                $entity=DB::table($ol.'.towns')
                ->select($ol.'.towns.name as name')
                ->where($ol.'.towns.id',$id)
                ->first();
                $recomendations = DB::table($ol.'.towns')
                ->Join($ol.'.headquarters',$ol.'.headquarters.town_id',$ol.'.towns.id')
                ->Join('game_users','game_users.headquarter_id',$ol.'.headquarters.id')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    $join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where($ol.'.towns.id',$id)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;
            case 1:
                $entity=DB::table($ol.'.departments')
                ->select($ol.'.departments.name as name')
                ->where($ol.'.departments.id',$id)
                ->first();
                $recomendations = DB::table($ol.'.departments')
                ->Join($ol.'.towns',$ol.'.towns.department_id',$ol.'.departments.id')
                ->Join($ol.'.headquarters',$ol.'.headquarters.town_id',$ol.'.towns.id')
                ->Join('game_users','game_users.headquarter_id',$ol.'.headquarters.id')
                ->Join('game_user_records','game_user_records.game_user_id','game_users.id')
                ->Join('mini_games','game_user_records.mini_game_id','mini_games.id')
                ->Join('subject_mini_game','subject_mini_game.mini_game_id','mini_games.id')
                ->Join('subjects','subject_mini_game.subject_id','subjects.id')
                ->Join('grades',function($join){
                    $join->on('game_users.grade_id','grades.id');
                    $join->on('mini_games.grade_id','grades.id');
                })
                ->select('grades.name as grade','grades.id as grade_id','subjects.name as name','subjects.id as subject_id',DB::raw('AVG(game_user_records.total_score) as average','performances.name as performance'))
                ->groupBy('grades.id','subjects.id')
                ->where($ol.'.departments.id',$id)
                ->orderBy('grades.id')
                ->orderBy('subjects.name')
                ->get()->groupBy('grade');
                break;

            default:
                return 'not implemented';
                break;
        }

         $img = '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $graph) . '">';

        $html = $img.'
            <h6 style="text-align:center">Resultados promedio por asignaturas</h6>
            <br></br>
        <h1 style="font-size: 25px; color: DimGrey;">Recomendaciones por Asignatura</h1>';

        foreach ($recomendations as $key => $value) {
            $html.='<h2 style="color: DimGrey;">Grado: <span style="text-transform: uppercase;">'.$key.'</span></h2>';
            for ($i = 0; $i < count($value); $i++) {
                $performance = DB::table('performances')
                ->select('name','id')
                ->whereRaw($value[$i]->average.' BETWEEN performances.min AND performances.max')
                ->first();

                $recomendation = DB::table('recomendations')
                ->select('recomendation')
                ->where('hierarchy_id',$locationType)
                ->where('performance_id',$performance->id)
                ->where('subject_id',$value[$i]->subject_id)
                ->first();

                $dbas = DB::table('subject_mini_game')
                ->join('mini_games','subject_mini_game.mini_game_id','mini_games.id')
                ->select('dba')
                ->where('subject_mini_game.subject_id',$value[$i]->subject_id)
                ->where('mini_games.grade_id',$value[$i]->grade_id)
                ->orderBy('dba')
                ->distinct()
                ->pluck('dba')->toArray();

                $html .=
                '<p>'.
                    '<b>Área: </b> <span style="text-transform: uppercase;">'.strtoupper($value[$i]->name).'</span> - '.
                    '<b>Promedio: </b>'.round($value[$i]->average,2).' - '.
                    '<b>Desempeño: </b><span style="text-transform: uppercase;">'.strtoupper($performance->name).
                '</span></p>'.
                '<p style="text-align:justify;">'.
                    ($recomendation?
                    ('<b>Recomendación: </b>'.$recomendation->recomendation):'').
                '</p>';

                $html .= '<span>Estos son los DBA que se debe reforzar: </span>';

                $html .= '<ul>';
                for ($j=0; $j < count($dbas); $j++) {
                    if(!empty($dbas[$j])){
                        $html .= '<li style="text-align:justify;">'.$dbas[$j].'</li>';
                    }
                }
                $html .= '</ul>';
                $html .= '<br></br>';
            }
        }
        PDF::SetTitle('Reporte Asignaturas');
        PDF::SetMargins(20, 30, 20, false);
        $this->setHeaders('Informe DBA', $name);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('vallemagico.pdf','D');
    }

    public function IntelligencesProgressByHierarchy(Request $request){

        $data = $request->only(['locationType','id','graph','name']);
        $locationType = $data['locationType'];
        $id = $data['id'];
        //$open_location = config('env_vars.open_location_url');
        $graph = $data['graph'];
        $name = $data['name'];

        $grade = null;
        $pos = strpos($id, "/");
        if($pos){
            list($id, $grade) = explode("/", $id);
        }

        $query = GetBaseStatsQueryByHierarchy($locationType,$id,$grade);

        $intelligencesIds=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->rightJoin('intelligence_indicators','gu_record_intelligence_ind_desc_styles.intelligence_indicator_id','intelligence_indicators.id')
        ->rightJoin('intelligences','intelligence_indicators.intelligence_id','intelligences.id')
        ->groupBy('intelligences.id')
        ->selectRaw('intelligences.id, ROUND(AVG(gu_record_intelligence_ind_desc_styles.percentage_value),2) as average')
        ->orderBy('average', 'DESC')
        ->take(3)
        ->get()->pluck('id')->toArray();

        $InformationmultipleIntelligences = GetIntelligencesRecomendations($intelligencesIds);

        $img = '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $graph) . '">';


        $html =
        /* '<h1>Informe por Inteligencias múltiples</h1>'.
        '<h2>'.$name.'</h2>'
        .  */$img. '
        <h6 style="text-align:center">Resultados promedio por asignaturas</h6>
            <br></br>
        <h1 style="color: DimGrey;">Inteligencias múltiples</h1>';

        foreach ($InformationmultipleIntelligences as $key => $value) {
                $html.= '<p></p>';
                $html.= '<h2 style="color: DimGrey;">'.$value["name"].'</h2>';
                $html.= '<p style="text-align:justify;">'.$value["desc"].'</p>';
                $html.= '<h4>Predominio</h4>';
                $html.= '<p style="text-align:justify;">'.$value["descPredominio"].'</p>';
                $html.= '<h4>Recomendaciones</h4>';
                $html.= '<p style="text-align:justify;">'.$value["recomendation"].'</p>';
        }
        PDF::SetTitle('Reporte Inteligencias');
        $this->setHeaders('Informe Inteligencias Múltiples', $name);
        PDF::SetMargins(20, 30, 20, false);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('vallemagico.pdf','D');

    }

    public function StylesProgressByHierarchy(Request $request){
        $data = $request->only(['locationType','id','graph','name']);
        $locationType = $data['locationType'];
        $id = $data['id'];
        //$open_location = config('env_vars.open_location_url');
        $graph = $data['graph'];
        $name = $data['name'];

        $grade = null;
        $pos = strpos($id, "/");
        if($pos){
            list($id, $grade) = explode("/", $id);
        }

        $query = GetBaseStatsQueryByHierarchy($locationType,$id,$grade);

        $query_styles=$query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->join('description_styles','gu_record_intelligence_ind_desc_styles.description_style_id','description_styles.id');

        $query_styles_by_user= (clone $query_styles)->groupBy('game_users.id')
        ->selectRaw('game_users.id, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_user');

        $query_styles_by_user_style=(clone $query_styles)->groupBy('description_styles.style_id','game_users.id')
        ->selectRaw('game_users.id as game_user_id, description_styles.style_id as style, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_orientation');

        $data=DB::table('total_styles_by_user_style')
                ->fromSub($query_styles_by_user_style,'total_styles_by_user_style')
                ->joinSub($query_styles_by_user,'total_styles_by_user','total_styles_by_user_style.game_user_id','total_styles_by_user.id')
                ->rightJoin('styles','total_styles_by_user_style.style','styles.id')
                ->groupBy('total_styles_by_user_style.style')
                ->selectRaw('styles.name, styles.id, ROUND(AVG(total_styles_by_user_style.total_by_orientation/total_styles_by_user.total_by_user),2)*100 as average')
                ->orderBy('average', "DESC")
                ->take(3)
                ->get()->pluck('id')->toArray();

                $InformationStyles = GetStylesRecomendations($data);

        $img = '<img src="@' . preg_replace('#^data:image/[^;]+;base64,#', '', $graph) . '">';

        $html =
        /* '<h1>Informe por Estilos de Aprendizaje</h1>'.
        '<h2>'.$name.'</h2>'
        .  */$img. '
        <h6 style="text-align:center">Resultados promedio por asignaturas</h6>
            <br></br>
        <h1 style="color: DimGrey;">Estilos de Aprendizaje</h1>';

        foreach ($InformationStyles as $key => $value) {
            $html.= '<p></p>';
            $html.= '<h2 style="color: DimGrey;">'.ucfirst($value["name"]).'</h2>';
            $html.= '<p style="text-align:justify;">'.$value["desc"].'</p>';
            $html.= '<p><b>Características:</b></p>';
            $html.= '<ul>';
            for ($j=0; $j < count($value["feature"]); $j++) {
                $html.= '<li style="text-align:justify;">'.$value["feature"][$j].'</li>';
            }
            $html.= '</ul>';
            $html.= '<p><b>'.$value["subtitleMetodology"].':</b></p>';
            $html.= '<p style="text-align:justify;">'.$value["preferenMetodology"][0].'</p>';
            $html.= '<p style="text-align:justify;"><b>'.$value["subtitledificult"].':</b></p>';
            $html.= '<ul>';
            for ($k=0; $k < count($value["dificult"]); $k++) {
                $html.= '<li style="text-align:justify;">'.$value["dificult"][$k].'</li>';
            }
            $html.= '</ul>';
            $html.= '<p></p>';
        }

        PDF::SetTitle('Reporte Estilos');
        $this->setHeaders('Informe Estilos de Aprendizaje',$name);
        PDF::SetMargins(20, 30, 20, false);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('vallemagico.pdf','D');
    }

    public function VocationsProgressByHierarchy(Request $request){
        $data = $request->only(['locationType','id','name']);
        $locationType = $data['locationType'];
        $id = $data['id'];
        $name = $data['name'];

        $grade = null;
        $pos = strpos($id, "/");
        if($pos){
            list($id, $grade) = explode("/", $id);
        }

        $query = GetBaseStatsQueryByHierarchy($locationType,$id,$grade);
        $query_vocations= $query->join('game_user_records','game_user_records.game_user_id','game_users.id')
        ->join('gu_record_intelligence_ind_desc_styles','gu_record_intelligence_ind_desc_styles.game_user_record_id','game_user_records.id')
        ->join('vocationals_orientations','gu_record_intelligence_ind_desc_styles.vocational_orientation_id','vocationals_orientations.id');

        $query_vocations_by_user= (clone $query_vocations)->groupBy('game_users.id')
        ->selectRaw('game_users.id, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_user');

        $query_vocations_by_user_orientation=(clone $query_vocations)->groupBy('vocationals_orientations.id','game_users.id')
        ->selectRaw('game_users.id as game_user_id, vocationals_orientations.id as vocational_orientation, COUNT(gu_record_intelligence_ind_desc_styles.id) as total_by_orientation');

        $data=DB::table('total_orientation_by_user_orientation')
                ->fromSub($query_vocations_by_user_orientation,'total_orientation_by_user_orientation')
                ->joinSub($query_vocations_by_user,'total_vocations_by_user','total_orientation_by_user_orientation.game_user_id','total_vocations_by_user.id')
                ->rightJoin('vocationals_orientations','total_orientation_by_user_orientation.vocational_orientation','vocationals_orientations.id')
                ->groupBy('vocationals_orientations.id')
                ->selectRaw('vocationals_orientations.name, vocationals_orientations.id, ROUND(AVG(total_orientation_by_user_orientation.total_by_orientation/total_vocations_by_user.total_by_user),2)*100 as average')
                ->orderBy('average', "DESC")
                ->take(3)
                ->get()->pluck('id')->toArray();
                $InformationVocations = GetVocationsRecomendations($data);

        $html =
        '<h1 style="color: DimGrey;">Informe Vocacional</h1>';

        foreach ($InformationVocations as $key => $value) {
            $html.= '<p></p>';
            $html.= '<h2 style="color: DimGrey;">'.ucfirst($value["title"]).'</h2>';
            $html.= '<p style="text-align:justify;">'.$value["text"]." ".$value["list"][0].'</p>';
            $html.= '<p style="text-align:justify;">'.$value["works"].'</p>';
            $html.= '<p></p>';
        }

        // set header and footer fonts
        PDF::SetTitle('Reporte Orientación Vocacional');
        $this->setHeaders('Informe Orientación Vocacional',$name);
        PDF::SetMargins(20, 30, 20, false);
        PDF::AddPage();
        PDF::writeHTML($html, true, false, true, false, '');
        PDF::Output('vallemagico.pdf','D');

        return $InformationVocations;
    }

    public function setHeaders($name,$entity){
        $img=Storage::disk('local_image')->get('logo.jpg');
        PDF::setHeaderCallback(function($pdf) use($img,$name,$entity) {
            $pdf->SetMargins(20, 3, 20, true);
            $pdf->SetFont('helvetica', 'B', 20);
            $pdf->SetTextColor(160,160,160);
            $pdf->setY(5);
            $pdf->Write(0,$name);
            $pdf->Ln();
            $pdf->Write(0,ucwords(strtolower($entity)));
            $pdf->Image('@'.$img, 3, 3, 30, '', 'PNG', '', 'T', false, 300, 'R', false, false, 0,     false, false, false);
            $pdf->setY(25);
            $pdf->SetMargins(20, 30, 20, false);
        });
    }
}
