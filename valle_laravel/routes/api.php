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
Route::get('/headquartersByInstitution/{id}', 'ChildHierarchy@headquartersByInstitutions');
Route::get('/groupsByHeadquarter/{id}', 'ChildHierarchy@groupsByHeadquarters');
Route::get('/studentsByGroup/{id1}/{id2}', 'ChildHierarchy@studentsByGroups');

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

// get data for CSV
Route::get('/dataByDepartment/{departmentID}', 'Downloadcsv2@getDataByDepartment');
Route::get('/dataByTown/{townID}', 'Downloadcsv2@getDataByTown');
Route::get('/dataByInstitution/{institutionID}', 'Downloadcsv2@getDataByInstitution');
Route::get('/dataByHeadquarter/{headquarterID}', 'Downloadcsv2@getDataByHeadquarter');
Route::get('/dataByHeadquarterGroup/{headquarterID}/{groupID}', 'Downloadcsv2@getDataByHeadquarterGroup');
Route::get('/dataByStudent/{studentID}', 'Downloadcsv2@getDataByStudent');

// PDF
Route::post('/pdf/knowledgeArea', 'DownloadPDF@knowledgeAreaProgressByHierarchy');
Route::post('/pdf/intelligences', 'DownloadPDF@IntelligencesProgressByHierarchy');
Route::post('/pdf/styles', 'DownloadPDF@StylesProgressByHierarchy');
Route::post('/pdf/vocations', 'DownloadPDF@VocationsProgressByHierarchy');

//Test
Route::get('/testareas/{type}/{id}','StatsController@getByKnowledgeAreasByLocation');
Route::get('/testareas/{type}/{id}/{grade}','StatsController@getByKnowledgeAreasByLocation');

Route::get('/testintelligences/{type}/{id}','StatsController@getByIntelligencesByLocation');
Route::get('/testintelligences/{type}/{id}/{grade}','StatsController@getByIntelligencesByLocation');

Route::get('/teststyles/{type}/{id}','StatsController@getByStylesByLocation');
Route::get('/teststyles/{type}/{id}/{grade}','StatsController@getByStylesByLocation');

Route::get('/testcompetences/{type}/{id}','StatsController@getByCompetencesByLocation');
Route::get('/testcompetences/{type}/{id}/{grade}','StatsController@getByCompetencesByLocation');

Route::get('/testRecomendationsAreas/{type}/{id}','StatsController@getKnowledgeAreasRecomendationsByLocation');
Route::get('/testRecomendationsAreas/{type}/{id}/{grade}','StatsController@getKnowledgeAreasRecomendationsByLocation');

Route::get('/testRecomendationsIntelligences/{type}/{id}','StatsController@getIntelligencesRecomendationsByLocation');
Route::get('/testRecomendationsIntelligences/{type}/{id}/{grade}','StatsController@getIntelligencesRecomendationsByLocation');


Route::get('/pdf/testHeaders', 'DownloadPDF@testHeaders');
