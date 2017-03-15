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
use Illuminate\Support\Facades\Artisan;

Route::get('/migrate', function () {
    Artisan::call('migrate:rollback');
    Artisan::call('migrate');
    Artisan::call('db:seed', array('--class' => 'UsersTableSeeder'));
    Artisan::call('db:seed', array('--class' => 'UsersTypesTableSeeder'));
    return 'All migrates and seed run';
});

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
    /*if (File::exists('\App\Http\Controllers\\'.ucfirst($controller).'Controller'))
    {
        echo "tak";
    }*/    
    $object = $app->make('\App\Http\Controllers\\'.(Auth::check() ? ucfirst($controller) : 'Auth').'Controller');    
    return $object->callAction('show', $parameters = array());
  });


Route::post('api/signin','AuthController@signin');
Route::post('api/signout','AuthController@signout');
Route::get('api/users/info','AuthController@info');

Route::get('api/users/types','UsersController@get_users_types');
Route::get('api/users/list','UsersController@get_all');
Route::post('api/users/save','UsersController@save');
Route::get('api/users/view/{id}','UsersController@view');
Route::delete('api/users/delete/{id}','UsersController@delete');







Route::get('users/test/{id}','UsersController@delete');
