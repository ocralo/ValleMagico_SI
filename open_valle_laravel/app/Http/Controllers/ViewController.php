<?php

namespace App\Http\Controllers;

use App\Department;
use Illuminate\Http\Request;

class ViewController extends Controller
{
    function departments(){
       return view('departments',["departments"=>Department::all()]);
    }
}
