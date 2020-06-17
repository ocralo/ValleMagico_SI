<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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
Route::get('/init/{username}', 'GameUserController@init');
Route::get('/userInfo/{username}', 'Api\UserInfo@get');
Route::put('/saveRecords', 'Api\SaveRecords@save');

Route::post('/simat', 'Api\Simat@save');

Route::get('/trying/{id}', 'Api\UserInfo@getByRole');

//hierarchy childs
Route::get('/townsByDepartment/{id}', 'ChildHierarchy@townsByDepartment');
Route::get('/institutionsByTown/{id}', 'ChildHierarchy@institutionsByTown');
Route::get('/headquartersByInstitutions/{id}', 'ChildHierarchy@headquartersByInstitutions');
Route::get('/groupsByHeadquarters', 'ChildHierarchy@groupsByHeadquarters');
Route::get('/studentsByGroups/{id1},{id2}', 'ChildHierarchy@studentsByGroups');

//title names
Route::get('/department/{id}', 'TitleNames@departmentName');
Route::get('/town/{id}', 'TitleNames@townName');
Route::get('/institution/{id}', 'TitleNames@institutionName');
Route::get('/headquarter/{id}', 'TitleNames@headquarterName');
Route::get('/group/{id}', 'TitleNames@groupName');
Route::get('/student/{id}', 'TitleNames@studentName');

//eliminar
Route::get('/getUserByName/{username}', 'UserController@getByUsername');
Route::post('/createUser', 'UserController@createUser');
