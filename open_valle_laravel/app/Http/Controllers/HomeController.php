<?php

namespace App\Http\Controllers;

use App\Department;
use App\Headquarter;
use App\Institution;
use Illuminate\Http\Request;
use stdClass;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $dashboard = new stdClass();
        $dashboard->totalDepartments = Department::count();
        $dashboard->totalHeadquarters = Headquarter::count();
        $dashboard->totalInstitutions = Institution::count();
        return view('home',['dashboard'=>$dashboard]);
    }
}
