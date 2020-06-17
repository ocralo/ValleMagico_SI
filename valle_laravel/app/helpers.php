<?php 
use Illuminate\Support\Facades\DB;

if (!function_exists('setCompetencesArray')) {
    function setCompetencesArray() {
        $toReturn = array();
        $get_competences = DB::table('competences')
                            ->select('id')
                            ->get();
        $competences = array();
        foreach ($get_competences as $key => $element) {
            $toReturn[$element->id] = array();
        }
        return $toReturn;
    }
}

if (!function_exists('getHeadquarters')) {
    function getHeadquarters($locationType, $id) {
        // $open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $headquarters = json_decode(file_get_contents($open_location.'api/'.$locationType.'sHeadquarters/'.$id), true);
        $array_ids_headquarters = [];
        foreach ($headquarters as $headqrtr) {
            array_push($array_ids_headquarters, $headqrtr['id']);
        }
        return $array_ids_headquarters;
    }
}

if (!function_exists('explode_descriptions')) {
    function explode_descriptions($descriptions) {
        foreach ($descriptions as $key => $element) {
            if (strrpos($element, '--') !== false) {
                $descriptions[$key] = explode('--', $element);
                $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
            }
        }
        return $descriptions;
    }
}

if (!function_exists('getGlobalIntelligencesInfo')) {
    function getGlobalIntelligencesInfo($db_result) {
        $sums_percentage_value_by_user = [];
        $average_by_intelligence = [];
        $descriptions = [];
        $toReturn = [];

        // Save the total of percentage for each student in an array divided by intelligences
        foreach ($db_result as $key => $element) {
            if (!isset($sums_percentage_value_by_user[$element->id][$element->name])) {
                $sums_percentage_value_by_user[$element->id][$element->name] = 0;
            }
            $sums_percentage_value_by_user[$element->id][$element->name] += $element->percentage_value;
            // Save the descriptions in an array, divided by intelligences
            if (!isset($descriptions[$element->name])) {
                $descriptions[$element->name] = $element->description;
            }
            $descriptions[$element->name] .= '--'.$element->description;
        }
        $sums_percentage_value_by_user = array_values($sums_percentage_value_by_user);
        // Calculate the average for every intelligence
        foreach ($sums_percentage_value_by_user as $key => $element) {
            $element = (array) $element;
            foreach ($element as $key_ => $value) {
                if (!isset($average_by_intelligence[$key_])) {
                    $average_by_intelligence[$key_] = [];
                }
                array_push($average_by_intelligence[$key_], $value);
            }
        }
        foreach ($average_by_intelligence as $key => $element) {
            $average_by_intelligence[$key] = array_sum($element) / count($element);
        }
        // Make an array of descriptions
        foreach ($descriptions as $key => $element) {
            if (strrpos($element, '--') !== false) {
                $descriptions[$key] = explode('--', $element);
                $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
            }
        }
        // Make the array to Return
        foreach ($average_by_intelligence as $key => $element) {
            $obj_to_push = array('average'=>round($element, 2), 'all_desc'=>$descriptions[$key], 'name'=>$key);
            array_push($toReturn, $obj_to_push);
        }

        return $toReturn;
    }
}

if (!function_exists('getGlobalIntelligencesByCompetenceInfo')) {
    function getGlobalIntelligencesByCompetenceInfo($db_result) {
        $sums_percentage_value_by_user = [];
        $average_by_intelligence = [];
        $descriptions = [];
        $toReturn = setCompetencesArray();

        // Divide info by competence
        foreach ($db_result as $key => $element) {
            array_push($toReturn[$element->competence], $element);
        }
        foreach ($toReturn as $key_tr => $competence) {
            // Save the total of percentage for each student in an array divided by intelligences
            foreach ($competence as $key => $element) {
                if (!isset($sums_percentage_value_by_user[$element->id][$element->name])) {
                    $sums_percentage_value_by_user[$element->id][$element->name] = 0;
                }
                $sums_percentage_value_by_user[$element->id][$element->name] += $element->percentage_value;
                // Save the descriptions in an array, divided by intelligences
                if (!isset($descriptions[$element->name])) {
                    $descriptions[$element->name] = $element->description;
                }
                $descriptions[$element->name] .= '--'.$element->description;
            }
            $sums_percentage_value_by_user = array_values($sums_percentage_value_by_user);
            // Calculate the average for every intelligence
            foreach ($sums_percentage_value_by_user as $key => $element) {
                $element = (array) $element;
                foreach ($element as $key_ => $value) {
                    if (!isset($average_by_intelligence[$key_])) {
                        $average_by_intelligence[$key_] = [];
                    }
                    array_push($average_by_intelligence[$key_], $value);
                }
            }
            foreach ($average_by_intelligence as $key => $element) {
                $average_by_intelligence[$key] = array_sum($element) / count($element);
            }
            // Make an array of descriptions
            foreach ($descriptions as $key => $element) {
                if (strrpos($element, '--') !== false) {
                    $descriptions[$key] = explode('--', $element);
                    $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
                }
            }
            // Make the array to Return
            $competence = [];
            foreach ($average_by_intelligence as $key => $element) {
                $obj_to_push = array('average'=>round($element, 2), 'all_desc'=>$descriptions[$key], 'name'=>$key);
                array_push($competence, $obj_to_push);
            }
            $toReturn[$key_tr] = $competence;
            $sums_percentage_value_by_user = [];
            $average_by_intelligence = [];
            $descriptions = [];
        }

        return $toReturn;
    }
}

if (!function_exists('getGlobalStylesInfo')) {
    function getGlobalStylesInfo($db_result) {
        $sums_quantities_by_user = [];
        $quantity_by_style = [];
        $descriptions = [];
        $extra_names = [];
        $toReturn = [];

        // Save the total of quantities for each student in an array divided by styles
        foreach ($db_result as $key => $element) {
            if (!isset($sums_quantities_by_user[$element->id][$element->name])) {
                $sums_quantities_by_user[$element->id][$element->name] = 0;
            }
            $sums_quantities_by_user[$element->id][$element->name]++;
            // Save the descriptions in an array, divided by styles
            if (!isset($descriptions[$element->name])) {
                $descriptions[$element->name] = $element->description;
            }
            $descriptions[$element->name] .= '--'.$element->description;
            // Save the extra name for every style
            if (!isset($extra_names[$element->name])) {
                $extra_names[$element->name] = $element->extra_name;
            }
        }
        $sums_quantities_by_user = array_values($sums_quantities_by_user);
        // Calculate the average for every style
        foreach ($sums_quantities_by_user as $key => $element) {
            $element = (array) $element;
            foreach ($element as $key_ => $value) {
                if (!isset($quantity_by_style[$key_])) {
                    $quantity_by_style[$key_] = [];
                }
                array_push($quantity_by_style[$key_], $value);
            }
        }
        foreach ($quantity_by_style as $key => $element) {
            $quantity_by_style[$key] = array_sum($element);
        }
        // Make an array of descriptions
        foreach ($descriptions as $key => $element) {
            if (strrpos($element, '--') !== false) {
                $descriptions[$key] = explode('--', $element);
                $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
            }
        }
        // Make the array to Return
        foreach ($quantity_by_style as $key => $element) {
            $obj_to_push = array('average'=>round($element, 2), 'all_desc'=>$descriptions[$key], 'name'=>$key,
                                'extra_name'=>$extra_names[$key]);
            array_push($toReturn, $obj_to_push);
        }

        return $toReturn;
    }
}

if (!function_exists('getGlobalStylesByCompetenceInfo')) {
    function getGlobalStylesByCompetenceInfo($db_result) {
        $sums_quantities_by_user = [];
        $quantity_by_style = [];
        $descriptions = [];
        $extra_names = [];
        $toReturn = setCompetencesArray();

        // Divide info by competence
        foreach ($db_result as $key => $element) {
            array_push($toReturn[$element->competence], $element);
        }
        foreach ($toReturn as $key_tr => $competence) {
            // Save the total of quantities for each student in an array divided by styles
            foreach ($competence as $key => $element) {
                if (!isset($sums_quantities_by_user[$element->id][$element->name])) {
                    $sums_quantities_by_user[$element->id][$element->name] = 0;
                }
                $sums_quantities_by_user[$element->id][$element->name]++;
                // Save the descriptions in an array, divided by styles
                if (!isset($descriptions[$element->name])) {
                    $descriptions[$element->name] = $element->description;
                }
                $descriptions[$element->name] .= '--'.$element->description;
                // Save the extra name for every style
                if (!isset($extra_names[$element->name])) {
                    $extra_names[$element->name] = $element->extra_name;
                }
            }
            $sums_quantities_by_user = array_values($sums_quantities_by_user);
            // Calculate the average for every style
            foreach ($sums_quantities_by_user as $key => $element) {
                $element = (array) $element;
                foreach ($element as $key_ => $value) {
                    if (!isset($quantity_by_style[$key_])) {
                        $quantity_by_style[$key_] = [];
                    }
                    array_push($quantity_by_style[$key_], $value);
                }
            }
            foreach ($quantity_by_style as $key => $element) {
                $quantity_by_style[$key] = array_sum($element);
            }
            // Make an array of descriptions
            foreach ($descriptions as $key => $element) {
                if (strrpos($element, '--') !== false) {
                    $descriptions[$key] = explode('--', $element);
                    $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
                }
            }
            // Make the array to Return
            $competence = [];
            foreach ($quantity_by_style as $key => $element) {
                $obj_to_push = array('average'=>round($element, 2), 'all_desc'=>$descriptions[$key], 'name'=>$key,
                                    'extra_name'=>$extra_names[$key]);
                array_push($competence, $obj_to_push);
            }
            $toReturn[$key_tr] = $competence;
            $sums_quantities_by_user = [];
            $quantity_by_style = [];
            $descriptions = [];
            $extra_names = [];
        }

        return $toReturn;
    }
}

if (!function_exists('getGlobalVocationalsInfo')) {
    function getGlobalVocationalsInfo($db_result) {
        $sums_quantities_by_user = [];
        $quantity_by_vocational = [];
        $toReturn = [];

        // Save the total of quantities for each student in an array divided by vocationals
        foreach ($db_result as $key => $element) {
            if (!isset($sums_quantities_by_user[$element->game_user][$element->name])) {
                $sums_quantities_by_user[$element->game_user][$element->name] = 0;
            }
            $sums_quantities_by_user[$element->game_user][$element->name]++;
        }
        $sums_quantities_by_user = array_values($sums_quantities_by_user);
        // Calculate the average for every vocational
        foreach ($sums_quantities_by_user as $key => $element) {
            $element = (array) $element;
            foreach ($element as $key_ => $value) {
                if (!isset($quantity_by_vocational[$key_])) {
                    $quantity_by_vocational[$key_] = [];
                }
                array_push($quantity_by_vocational[$key_], $value);
            }
        }
        foreach ($quantity_by_vocational as $key => $element) {
            $quantity_by_vocational[$key] = array_sum($element);
        }
        // Make the array to Return
        foreach ($quantity_by_vocational as $key => $element) {
            $obj_to_push = array('average'=>round($element, 2), 'name'=>$key);
            array_push($toReturn, $obj_to_push);
        }

        return $toReturn;
    }
}

if (!function_exists('groupRecomendationsBySubAndGrade')) {
    function groupRecomendationsBySubAndGrade($db_result) {
        $sums_score_by_user = [];
        $average_by_subject = [];
        $subjects_name = [];
        $descriptions = [];
        $toReturn = [];

        // Set arrays by grade
        foreach ($db_result as $key => $element) {
            if (!isset($toReturn[$element->grade_id])) $toReturn[$element->grade_id] = [];
            array_push($toReturn[$element->grade_id], $element);
        }

        foreach ($toReturn as $key_tr => $elementByGrade) {
            // Save the total of score for each student in an array divided by subject
            foreach ($elementByGrade as $key => $element) {
                if (!isset($sums_score_by_user[$element->game_user][$element->subject_id])) {
                    $sums_score_by_user[$element->game_user][$element->subject_id] = array();
                }
                array_push($sums_score_by_user[$element->game_user][$element->subject_id], $element->total_score);
                // Save the descriptions in an array, divided by subject
                if (!isset($descriptions[$element->subject_id])) {
                    $descriptions[$element->subject_id] = [];
                }
                array_push($descriptions[$element->subject_id], $element->dba);
                // Save subjects name
                if (!isset($subjects_name[$element->subject_id])) {
                    $subjects_name[$element->subject_id] = [];
                }
                array_push($subjects_name[$element->subject_id], $element->name);
            }
            $sums_score_by_user = array_values($sums_score_by_user);
            // Calculate the average for every intelligence
            foreach ($sums_score_by_user as $key => $element) {
                foreach ($element as $key_ => $value) {
                    if (!isset($average_by_subject[$key_])) {
                        $average_by_subject[$key_] = [];
                    }
                    array_push($average_by_subject[$key_], $value[0]);
                }
            }
            foreach ($average_by_subject as $key => $element) {
                $average_by_subject[$key] = array_sum($element) / count($element);
            }
            // Make the array to Return
            $subject = [];
            foreach ($average_by_subject as $key => $element) {
                // Make dbas unique array
                $descriptions[$key] = array_values(array_unique($descriptions[$key], SORT_REGULAR));
                $obj_to_push = array('average'=>round($element, 2), 'all_dbas'=>$descriptions[$key], 'subject_id'=>$key, 'subject_name'=>$subjects_name[$key][0]);
                array_push($subject, $obj_to_push);
            }
            $toReturn[$key_tr] = $subject;
            $sums_score_by_user = [];
            $average_by_subject = [];
            $descriptions = [];
        }

        return $toReturn;
    }
}
?>