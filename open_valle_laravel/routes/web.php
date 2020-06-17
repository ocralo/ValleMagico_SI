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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

Route::get('/upload', function () {
    return view('fileLoader');
})->middleware('auth');
Route::post('/upload', 'UploadController@upload')->name('fileLoader')->middleware('auth');


//ViewRoutes
Route::get('departments','ViewController@departments')->name('departments');
