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

Route::get('/migratefull', function () {
    Artisan::call('migrate:rollback');
    Artisan::call('migrate');
    Artisan::call('db:seed', array('--class' => 'UsersTableSeeder'));
    Artisan::call('db:seed', array('--class' => 'UsersTypesTableSeeder'));
    Artisan::call('db:seed', array('--class' => 'GroupsTableSeeder'));
    Artisan::call('db:seed storage:link');
    return 'All migrates and seed run';
});
Route::get('/migrate', function () {
    //Artisan::call('migrate:rollback');
    Artisan::call('migrate');
    Artisan::call('db:seed storage:link');
    return 'New artisan run';
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
//Admin panel---------------
//auth
Route::post('api/signin','AuthController@signin');
Route::post('api/signout','AuthController@signout');
Route::get('api/users/info','AuthController@info');
//users
Route::get('api/users/types','UsersController@get_users_types');
Route::get('api/users/list','UsersController@get_all');
Route::post('api/users/save','UsersController@save');
Route::get('api/users/view/{id}','UsersController@view');
Route::delete('api/users/delete/{id}','UsersController@delete');
//cats
Route::get('api/cats/list','CatsController@get_all');
Route::post('api/cats/save','CatsController@save');
Route::delete('api/cats/delete/{id}','CatsController@delete');
Route::get('api/cats/filters/{id}','CatsController@get_filters');
Route::get('api/cats/features/{id}','CatsController@get_features');
//brands
Route::get('api/brands/list','BrandsController@get_all');
Route::post('api/brands/save','BrandsController@save');
Route::delete('api/brands/delete/{id}','BrandsController@delete');
//filters
Route::get('api/filters/list','FiltersController@get_all');
Route::get('api/filters/list_groups','FiltersController@get_all_groups');
Route::post('api/filters/save','FiltersController@save');
Route::delete('api/filters/delete/{id}','FiltersController@delete');
//prods
Route::get('api/prods/list','ProdsController@get_all');
Route::post('api/prods/save','ProdsController@save');
Route::delete('api/prods/delete/{id}','ProdsController@delete');
//features
Route::get('api/features/list','FeaturesController@get_all');
Route::post('api/features/save','FeaturesController@save');
Route::delete('api/features/delete/{id}','FeaturesController@delete');
//-------------------------
//Front
Route::get('api/cats/front/shortlist','CatsController@shortlist');
Route::post('api/compare/list','ProdsController@get_compare_prods');







//for testing
//Route::get('test','ProdsController@get_prods_with_filters_group');
Route::get('test','ProdsController@get_compare_prods');
//Route::get('testapi','UsersController@get_all')->middleware('respapi');

