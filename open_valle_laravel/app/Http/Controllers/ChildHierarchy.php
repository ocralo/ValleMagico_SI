<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ChildHierarchy extends Controller
{
    //
    public function townsByDepartment ($id) {
        $id = strtoupper($id);
        $town = DB::table('towns')->select('name', 'id')->where('department_id', $id)->get();
        return $town;
    }

    public function institutionsByTown ($id) {
        $id = strtoupper($id);
        $institutions = DB::table('institutions')
        ->join('headquarters', 'headquarters.institution_id', '=', 'institutions.id')
        ->where('headquarters.town_id', '=', $id)
        ->select('institutions.name', 'institutions.id')
        ->get();
        return $institutions;
    }
    

    public function headquartersByInstitution ($id) {
        $id = strtoupper($id);
        $headquarters = DB::table('headquarters')->select('name', 'id')->where('institution_id', $id)->get();
        return $headquarters;
    }
}
