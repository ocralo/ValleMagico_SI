<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class GetPerformances extends Controller
{
    protected function get() {
        $db_result = DB::table('performances')->select('min', 'max', 'name')->get();
        return $db_result;
    }
}
