<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('auth.login');
// });


Route::get('/', 'Auth\LoginController@showLoginForm')->name('login');
// Route::get('login', 'Auth\LoginController@showLoginForm')->name('login');
// Route::post('login', 'Auth\LoginController@login');
Route::get('/si/logout', 'Auth\LoginController@logout')->name('logout');

// Registration Routes...
if ($options['register'] ?? true) {
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register');
    Route::post('register', 'Auth\RegisterController@register');
}

// Password Reset Routes...
if ($options['reset'] ?? true) {
    Route::resetPassword();
}

// Email Verification Routes...
if ($options['verify'] ?? false) {
    Route::emailVerification(); 
}

Auth::routes();

Route::get('si/home', 'HomeController@index')->name('home');

// Route::get('si/{path?}', 'HomeController@index')->name('home');
// Route::get('si/{path?}', 'HomeController@index')->name('home');


// Route::view('/{path?}', 'home');

Route::get('si/{path?}', function () {
    return view('home'); // or wherever your React app is bootstrapped.
})->where('path', '.*');


// Route::get('/test/{id}', function ($id) {
//     return json_decode(file_get_contents('http://localhost:8000/api/department/'.$id), true);;
// });

Route::middleware(['auth'])->group(function () {    

// Permissions
Route::get('/permissions/all', 'ViewController@getPermissionsAll');
Route::get('/permissions/{User}', 'ViewController@getPermissions');

// Users 
Route::get('/users/all', 'UserController@getUsersAll');
Route::post('/createUser', 'UserController@createUser');
Route::get('/getUser/{id}', 'UserController@getUser');
Route::put('/updateUser/{id}', 'UserController@updateUser');
Route::delete('/destroyUser/{id}', 'UserController@destroyUser');


// Roles
Route::get('/roles/all', 'RoleController@getRolesAll');
Route::get('/getRole/{id}', 'RoleController@getRole');
Route::put('/updateRole/{id}', 'RoleController@updateRole');
Route::post('/createRole', 'RoleController@createRole');
Route::delete('/deleteRole/{id}', 'RoleController@destroyRole');

});
Route::get('/try-redis', 'RedisController@index');

Route::get('/infoUser/{id}', 'Api\UserInfo@getByRole');
Route::post('/infoUser/students', 'Api\UserInfo@getStudentsByRole');
Route::post('/infoUser/grades', 'Api\UserInfo@getGradesByRole');

// Intelligences by competence
Route::get('/competences/intelligences/headquarter/{id}', 'Api\GetByHeadquarter@getIntelligencesByCompetence');
Route::get('/competences/styles/headquarter/{id}', 'Api\GetByHeadquarter@getStylesByCompetence');
Route::get('/competences/intelligences/grade/{headquarter}/{id}', 'Api\GetByGrade@getIntelligencesByCompetence');
Route::get('/competences/styles/grade/{headquarter}/{id}', 'Api\GetByGrade@getStylesByCompetence');
Route::get('/competences/intelligences/{locationType}/{id}', 'Api\GetByLocationType@getIntelligencesByCompetence');
Route::get('/competences/styles/{locationType}/{id}', 'Api\GetByLocationType@getStylesByCompetence');
Route::get('/competences/intelligences/{username}', 'Api\GetByStudent@getIntelligencesByCompetence');
Route::get('/competences/styles/{username}', 'Api\GetByStudent@getStylesByCompetence');

// Intelligences
Route::get('/intelligences/headquarter/{id}', 'Api\GetByHeadquarter@getIntelligences');
Route::get('/intelligences/grade/{headquarter}/{id}', 'Api\GetByGrade@getIntelligences');
Route::get('/intelligences/byGrade/{username}', 'Api\GetInfoIntelligences@getOneByGrade');
Route::get('/intelligences/{locationType}/{id}', 'Api\GetByLocationType@getIntelligences');
Route::get('/intelligences/{username}', 'Api\GetInfoIntelligences@getOne');
Route::post('/intelligences', 'Api\GetInfoIntelligences@getMoreThanOne');

// Styles
Route::get('/styles/headquarter/{id}', 'Api\GetByHeadquarter@getStyles');
Route::get('/styles/grade/{headquarter}/{id}', 'Api\GetByGrade@getStyles');
Route::get('/styles/{locationType}/{id}', 'Api\GetByLocationType@getStyles');
Route::get('/styles/{username}', 'Api\GetInfoStyles@getOne');
Route::post('/styles', 'Api\GetInfoStyles@getMoreThanOne');

// Get by subjects (initials)
Route::get('/students/{locationType}/{locationId}', 'Api\GetStudents@get');
Route::get('/grade/{headquarter}/{id}', 'Api\GetByGrade@get');
Route::get('/student/{id}', 'Api\GetByStudent@get');
Route::get('/subject/{id}', 'Api\GetBySubject@get');
Route::get('/headquarter/{id}', 'Api\GetByHeadquarter@get');
Route::post('/simat/{dataType}', 'Api\Simat@save');
Route::get('/{locationType}/{id}', 'Api\GetByLocationType@get');
Route::get('/playersPlayed', 'Api\GetPlayersPlayed@get');

// Get by subject and show minigames 
Route::get('/bySubject/grade/{headquarter}/{id}/{subject}', 'Api\GetByGrade@getBySubject');
Route::get('/bySubject/student/{id}/{subject}', 'Api\GetByStudent@getBySubject');
Route::get('/bySubject/headquarter/{id}/{subject}', 'Api\GetByHeadquarter@getBySubject');
Route::get('/bySubject/{locationType}/{id}/{subject}', 'Api\GetByLocationType@getBySubject');

// Games played and intelligences
Route::get('/gamesPlayed/student/{id}', 'Api\GetGamesPlayed@getByStudent');
Route::get('/gamesPlayed/student/{id}/{intelligences}', 'Api\GetGamesPlayed@getByStudent');
Route::get('/gamesPlayed/grade/{headquarter_id}/{id}', 'Api\GetGamesPlayed@getByGrade');
Route::get('/gamesPlayed/grade/{headquarter_id}/{id}/{intelligences}', 'Api\GetGamesPlayed@getByGrade');
Route::get('/gamesPlayed/headquarter/{id}', 'Api\GetGamesPlayed@getByHeadquarter');
Route::get('/gamesPlayed/headquarter/{id}/{intelligences}', 'Api\GetGamesPlayed@getByHeadquarter');
Route::get('/gamesPlayed/{locationType}/{id}', 'Api\GetGamesPlayed@getByLocationType');
Route::get('/gamesPlayed/{locationType}/{id}/{intelligences}', 'Api\GetGamesPlayed@getByLocationType');

// Get average by grade
Route::get('/byGrade/school/student/{username}', 'Api\GetByStudent@getScoreByMGGradeAndSubjectForSchool');
Route::get('/byGrade/student/{username}', 'Api\GetByStudent@getScoreByMGGradeAndSubject');
// Route::get('/byGrade/grade/{headquarter}/{id}', 'Api\GetByGrade@getScoreByMGGrade');
// Route::get('/byGrade/headquarter/{id}', 'Api\GetByHeadquarter@getScoreByMGGrade');
// Route::get('/byGrade/{locationType}/{id}', 'Api\GetByLocationType@getScoreByMGGrade');

// Get vocationals
Route::get('/vocationals/student/{username}', 'Api\GetByStudent@getVocationals');
Route::get('/vocationals/grade/{headquarter}/{id}', 'Api\GetByGrade@getVocationals');
Route::get('/vocationals/headquarter/{id}', 'Api\GetByHeadquarter@getVocationals');
Route::get('/vocationals/{locationType}/{id}', 'Api\GetByLocationType@getVocationals');

// Get info about dbas and recomendations
Route::get('/recomendations/student/{username}', 'Api\GetByStudent@getRecomendationsAndDbas');
Route::get('/recomendations/grade/{headquarter}/{id}', 'Api\GetByGrade@getRecomendationsAndDbas');
Route::get('/recomendations/headquarter/{id}', 'Api\GetByHeadquarter@getRecomendationsAndDbas');
Route::get('/recomendations/{locationType}/{id}', 'Api\GetByLocationType@getRecomendationsAndDbas');

// Get performances
Route::get('/performances', 'Api\GetPerformances@get');