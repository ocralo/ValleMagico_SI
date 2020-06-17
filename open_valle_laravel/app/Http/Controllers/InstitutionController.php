<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Institution;

use Illuminate\Support\Facades\DB;


class InstitutionController extends Controller
{
    public function institution($id){
        $institution = Institution::with(['headquarters.town.department'])->findOrFail($id);
        return $institution;
    }
    public function institutionByName($name){
        $name = strtoupper($name);
        $institution = DB::table('institutions')->select('id')->where('name', $name)->get();
        return $institution;
    }
    public function headquarters($id){
        $headquarters = DB::table('headquarters')
        ->join('institutions', 'institutions.id', '=', 'headquarters.institution_id')
        ->where('institutions.id','=',$id)
        ->select('headquarters.id','headquarters.name')
        ->get();
        return $headquarters;
    }
    public function institutionName($id) {
        $name = DB::table('institutions')->select('name')->where('id', $id)->get();
        return $name;
    }
    public function store(Request $request)
    {
        $institution = new Institution;

        $institution->name = $request->name;

        $institution->save();
        return $institution;
    }
}
