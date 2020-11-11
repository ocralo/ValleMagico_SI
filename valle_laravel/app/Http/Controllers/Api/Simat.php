<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

use App\GameUser;
use App\DissabilityGameUser;

class Simat extends Controller
{
    /**
     * Receives a JSON and add a new row in the students table.
     */
    protected function save(Request $request) {
        // return $request->get('users');
        $users = $request->get('users');
        foreach ($users as $key=>$user) {
            $user = (object) $user;
            // Get headquarter by the name sent or create a new headquarter
            $headquarter_url = strtoupper(str_replace('_', '%20', $user->nombre_sede));
            $headquarter = strtoupper(str_replace('_', ' ', $user->nombre_sede));
            // $open_location = config('env_vars.open_location_url');
            $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
            $headquarter_id = json_decode(file_get_contents($open_location.'api/headquarterByName/'.$headquarter_url), true);
            if (isset($headquarter_id[0])) {
                $headquarter_id = $headquarter_id[0]["id"];
            } else {
                // Search for the institution and create it if doesn't exist
                $institution_url = strtoupper(str_replace('_', '%20', $user->nombre_institucion));
                $institution = strtoupper(str_replace('_', ' ', $user->nombre_institucion));
                $institution_id = json_decode(file_get_contents($open_location.'api/institutionByName/'.$institution_url), true);
                if (isset($institution_id[0])) {
                    $institution_id = $institution_id[0]["id"];
                } else {
                    $institution_id = $this->newInstitution($institution)["id"];
                }
                // Search for the town and create it if doesn't exist
                $town_url = strtoupper(str_replace('_', '%20', $user->nombre_municipio));
                $town = strtoupper(str_replace('_', ' ', $user->nombre_municipio));
                $town_id = json_decode(file_get_contents($open_location.'api/townByName/'.$town_url), true);
                if (isset($town_id[0])) {
                    $town_id = $town_id[0]["id"];
                } else {
                    $region = strtoupper(str_replace('_', ' ', $user->region));
                    $zone = strtoupper(str_replace('_', ' ', $user->zona));
                    $town_id = $this->newTown($town, $region, $zone)["id"];
                }
                $headquarter_id = $this->newHeadquarter($headquarter, $town_id, $institution_id)["id"];
            }

            // Get dissability id by its name
            $diss = DB::table('dissabilities')->select('id')->where('name', $user->discapacidad)->get();
            $diss_id = $diss[0]->id;

            $map_skin_id = $user->map_skin_id ?? 100;
            $username = $user->nombre1[0].$user->nombre2[0].$user->apellido1.substr($user->doc, -4);

            $correct = GameUser::create([
                'first_name' => strtoupper($user->nombre1),
                'second_name' => strtoupper($user->nombre2),
                'first_surname' => strtoupper($user->apellido1),
                'second_surname' => strtoupper($user->apellido2),
                'username' => strtoupper($username),
                'headquarter_id' => $headquarter_id,
                'grade_id'=>$user->grado_cod,
                'map_skin_id' => $map_skin_id
            ]);

            if  ($correct) {
                $correct_dissability_relation = DissabilityGameUser::create([
                    'game_user_id' => $correct->id,
                    'dissability_id' => $diss_id
                ]);
            } else {
                http_response_code(400);
                echo json_encode(array("message" => "There was an error saving the info."));
            }

        }

        if ($correct_dissability_relation) {
            http_response_code(201);
            echo json_encode(array("message" => "Info saved correctly."));
        } else {
            http_response_code(400);
            echo json_encode(array("message" => "There was an error saving the info."));
        }
    }

    protected function get($diss) {
        $diss = DB::table('dissabilities')->select('id')->where('name', $diss)->get();
        return $diss[0]->id;
    }

    protected function newHeadquarter($name, $town, $institution) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $data = array('name' => $name, 'town' => $town, 'institution' => $institution);
        $url = $open_location.'api/headquarters';
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context), true);
        return $result;
    }
    protected function newInstitution($name) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/city/ol/';
        $data = array('name' => $name);
        $url = $open_location.'api/institutions';
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context), true);
        return $result;
    }
    protected function newTown($name, $zone, $town_type) {
        //$open_location = config('env_vars.open_location_url');
        $open_location = 'http://'.$_SERVER['SERVER_ADDR'].':8088/valle/ol/';
        $data = array('department' => 2, 'name' => $name, 'zone' => $zone, 'type' => $town_type);
        $url = $open_location.'api/towns';
        $options = array(
            'http' => array(
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => http_build_query($data)
            )
        );
        $context  = stream_context_create($options);
        $result = json_decode(file_get_contents($url, false, $context), true);
        return $result;
    }
}
