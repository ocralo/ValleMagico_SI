<?php

namespace App\Http\Controllers;

use App\Headquarter;
use App\Institution;
use App\Town;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HeadquarterController extends Controller
{
    //
    public function headquarter($id){
        $headquarter = Headquarter::with(['institution','town'])->findOrFail($id);
        return $headquarter;
    }

    public function headquarterByName($name){
        $name = strtoupper($name);
        $headquarter = DB::table('headquarters')->select('id')->where('name', $name)->get();
        return $headquarter;
    }
    public function headquarterName($id) {
        $name = DB::table('headquarters')->select('name')->where('id', $id)->get();
        return $name;
    }
    public function store(Request $request)
    {
        $headquarter = new Headquarter;

        $headquarter->name = $request->name;

        $town = Town::findOrFail($request->town);
        $headquarter->town()->associate($town);

        $institution = Institution::findOrFail($request->institution);
        $headquarter->institution()->associate($institution);

        $headquarter->save();
        return $headquarter;
    }
}
