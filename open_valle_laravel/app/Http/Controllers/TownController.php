<?php

namespace App\Http\Controllers;

use App\Department;
use App\Town;
use App\TownType;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class TownController extends Controller
{
    public function town($id){
        $department = Town::with(['type','headquarters.institution'])->findOrFail($id);
        return $department;
    }
    public function townByName($name){
        $name = strtoupper($name);
        $town = DB::table('towns')->select('id')->where('name', $name)->get();
        return $town;
    }
    public function headquarters($id){
        $headquarters = DB::table('headquarters')
        ->join('towns', 'towns.id', '=', 'headquarters.town_id')
        ->where('towns.id','=',$id)
        ->select('headquarters.id','headquarters.name')
        ->get();
        return $headquarters;
    }

    public function townName($id) {
        $name = DB::table('towns')->select('name')->where('id', $id)->get();
        return $name;
    }

    public function store(Request $request)
    {
        $town = new Town;

        $town->name = $request->name;
        $department = Department::findOrFail($request->department);
        $town->department()->associate($department);

        $town_zone = Zone::where('name',$request->zone)->first();

        if($town_zone == null){
            $town_zone = new Zone();
            $town_zone->name = $request->zone;
            $town_zone->save();
        }
        $town->zone()->associate($town_zone);

        $town_type = TownType::where('name',$request->type)->first();
        $town->type()->associate($town_type);

        $town->save();
        return($town);
    }
}
