<?php

namespace App\Http\Controllers\Api;

use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class Test2 extends Controller
{

    public function get($locationType){
        return $this->baseQuery($locationType)->count();
    }

    private function baseQuery($locationType)
    {
        $ol = env('OPEN_LOCATION_DB');
        switch ($locationType) {
            case 1:
                return DB::table($ol.'.departments as dp')
                        ->join($ol.'.towns as tw','tw.department_id','dp.id')
                        ->join($ol.'.headquarter as tw','tw.department_id','dp.id');
                break;
            case 2:
                return DB::table($ol.'.towns')
                        ->join($ol.'.headquarters',$ol.'.headquarters.town_id',$ol.'.towns.id');
                break;

            default:
                # code...
                break;
        }
    }
}
