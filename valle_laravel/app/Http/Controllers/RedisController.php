<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;

class RedisController extends Controller
{
    public function index() {
        Redis::set('name', 'Taylor');
        $name = Redis::get('name');
        return view('try_redis')->with('namee', $name);
    }
}
