<?php

namespace App\Http\Controllers;

use App\Department;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DepartmentController extends Controller
{
    public function department($id){
        $department = Department::with(['towns.type','towns.department','towns.headquarters.institution'])->findOrFail($id);
        return $department;
    }
    public function departmentByName($name){
        $name = strtoupper($name);
        $department = DB::table('departments')->select('id')->where('name', $name)->get();
        return $department;
    }
    public function headquarters($id){
        $headquarters = DB::table('headquarters')
        ->join('towns', 'towns.id', '=', 'headquarters.town_id')
        ->join('departments', 'departments.id', '=', 'towns.department_id')
        ->where('departments.id','=',$id)
        ->select('headquarters.id','headquarters.name')
        ->get();
        return $headquarters;
    }

    public function departmentName($id) {
        $name = DB::table('departments')->select('name')->where('id', $id)->get();
        return $name;
    }

    public function store(Request $request)
    {
        $department = new Department;

        $department->name = $request->name;
        $department->cod_dane = $request->cod_dane;

        $department->save();
        return $department;
    }

}
