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

<<<<<<< .merge_file_a96104
use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Blade;

//Blade::setEscapedContentTags('[[', ']]');
//Blade::setContentTags('[[[', ']]]');

Route::get('/', function () {    
    return view('welcome');
=======
Route::get('/', function () {
    return view('template');
>>>>>>> .merge_file_a93316
});

// Маршруты аутентификации...
Route::get('panel/login', 'Auth\AuthController@getLogin');
Route::post('panel/login', 'Auth\AuthController@postLogin');
Route::get('panel/logout', 'Auth\AuthController@getLogout');

// Маршруты регистрации...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');



//Route::get('compare/{list}', 'PagesController@test');
//Route::get('compare/{list}', 'PagesController@test');
//Route::any('/', 'PagesController@test');

//Route::get('panel', 'PanelController@admin');