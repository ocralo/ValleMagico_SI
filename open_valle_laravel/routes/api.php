<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::get('/departments/{id}', 'DepartmentController@department');
Route::get('/departmentsHeadquarters/{id}', 'DepartmentController@headquarters');
Route::get('/departmentByName/{name}', 'DepartmentController@departmentByName');
Route::post('/departments', 'DepartmentController@store');


Route::get('/towns/{id}', 'TownController@town');
Route::get('/townsHeadquarters/{id}', 'TownController@headquarters');
Route::get('/townByName/{name}', 'TownController@townByName');
Route::post('/towns', 'TownController@store');


Route::get('/institutions/{id}', 'InstitutionController@institution');
Route::get('/institutionsHeadquarters/{id}', 'InstitutionController@headquarters');
Route::get('/institutionByName/{name}', 'InstitutionController@institutionByName');
Route::post('/institutions', 'InstitutionController@store');

Route::get('/headquarters/{id}', 'HeadquarterController@headquarter');
Route::get('/headquarterByName/{name}', 'HeadquarterController@headquarterByName');
Route::post('/headquarters', 'HeadquarterController@store');

//hierarchy childs
Route::get('/townsByDepartment/{id}', 'ChildHierarchy@townsByDepartment');
Route::get('/institutionsByTown/{id}', 'ChildHierarchy@institutionsByTown');
Route::get('/headquartersByInstitution/{id}', 'ChildHierarchy@headquartersByInstitution');


//title names
Route::get('/department/{id}', 'DepartmentController@departmentName');
Route::get('/town/{id}', 'TownController@townName');
Route::get('/institution/{id}', 'InstitutionController@institutionName');
Route::get('/headquarter/{id}', 'HeadquarterController@headquarterName');