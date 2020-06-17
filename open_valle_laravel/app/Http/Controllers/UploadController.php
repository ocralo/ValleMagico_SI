<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Department;
use App\TownType;
use App\Town;
use App\Institution;
use App\Headquarter;

class UploadController extends Controller
{
    public function upload(Request $request){
        foreach (json_decode($request->data) as $row) {
            $department = Department::firstOrNew(['name'=>mb_strtoupper($row->DEPARTAMENTO,'UTF-8'),'cod_dane'=>($row->COD_DANE_DEPARTAMENTO)]);
            $department->save();

            $townType = TownType::firstOrNew(['name'=>mb_strtoupper($row->ZONA,'UTF-8')]);
            $townType->save();

            $town = Town::firstOrNew(['name'=>mb_strtoupper($row->MUNICIPIO,'UTF-8')]);
            $town->department_id = $department->id;
            $town->town_type_id=$townType->id;
            $town->save();

            $institution = Institution::firstOrNew(['name'=>mb_strtoupper($row->NOMBRE_EE,'UTF-8')]);
            $institution->save();

            $headquarter = Headquarter::firstOrNew(['name'=>mb_strtoupper($row->NOMBRE_SEDE,'UTF-8')]);
            $headquarter->town_id=$town->id;
            $headquarter->institution_id=$institution->id;
            $headquarter->save();
        }
        return view('fileLoader');
    }
}
