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
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Blade;

//Blade::setEscapedContentTags('[[', ']]');
//Blade::setContentTags('[[[', ']]]');


Route::get('/', function () {
    return view('template');
});
Route::get('/compare', function () {
    return view('template');
});
Route::get('/compare/{list}', function () {
    return view('template');
});

Route::get('/pages/index/', function () {
    return view('compare.index');
});
Route::get('/pages/{list}', function () {
    return view('compare.compare');
});

Route::get('/panel', function () {
    return view('panel.template');
});
Route::get('/panel/{controller}', function () {
    return view('panel.template');
});
Route::get('/panel/{controller}/{id}', function () {
    return view('panel.template');
});

Route::get('/pages/panel/dashboard', function () {
    return view('panel.dashboard');
});
Route::get('/pages/panel/{controller}', function($controller){    
    $app = app();    
    $object = $app->make('\App\Http\Controllers\\'.(Auth::check() ? ucfirst($controller) : 'Auth').'Controller');    
    return $object->callAction('show', $parameters = array());
  });


Route::post('api/signin','AuthController@signin');
Route::get('api/users/info','AuthController@info');
Route::post('api/signout','AuthController@signout');






// Маршруты аутентификации...
//Route::get('panel/login', 'Auth\AuthController@getLogin');
//Route::post('panel/login', 'Auth\AuthController@postLogin');
//Route::get('panel/logout', 'Auth\AuthController@getLogout');

// Маршруты регистрации...
//Route::get('auth/register', 'Auth\AuthController@getRegister');
//Route::post('auth/register', 'Auth\AuthController@postRegister');



//Route::get('compare/{list}', 'PagesController@test');
//Route::get('compare/{list}', 'PagesController@test');
//Route::any('/', 'PagesController@test');

//Route::get('panel', 'PanelController@admin');