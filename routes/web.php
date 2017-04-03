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
    //Artisan::call('db:seed', array('--class' => 'GroupsTableSeeder'));
    Artisan::call('db:seed', array('--class' => 'SettingsTableSeeder'));
    //Artisan::call('storage:link');
    return 'All migrates and seed run';
});
Route::get('/migrate', function () {    
    Artisan::call('migrate');
    Artisan::call('db:seed', array('--class' => 'SettingsTableSeeder'));
    return 'New migrate run';
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
Route::get('/pages/products/', function () {
    return view('compare.products');
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
    if (Auth::check()) return view('panel.dashboard');
    else return view('panel.signin');
});
Route::get('/pages/panel/{controller}', function($controller){        
    $app = app();   
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
Route::get('api/users/list','UsersController@get_show_list');
Route::post('api/users/save','UsersController@save');
Route::get('api/users/view/{id}','UsersController@view');
Route::delete('api/users/delete/{id}','UsersController@delete');
//cats
Route::get('api/cats/list','CatsController@get_access_list');
Route::get('api/cats/showlist','CatsController@get_show_list');
Route::post('api/cats/save','CatsController@save');
Route::delete('api/cats/delete/{id}','CatsController@delete');
Route::get('api/cats/filters/{id}','CatsController@get_filters');
Route::get('api/cats/features/{id}','CatsController@get_features');
Route::get('api/cats/brands/{id}','CatsController@get_brands');
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
//currencies
Route::get('api/currencies/list','CurrenciesController@get_all');
Route::get('api/currencies/showlist','CurrenciesController@get_show_list');
Route::post('api/currencies/save','CurrenciesController@save');
Route::delete('api/currencies/delete/{id}','CurrenciesController@delete');
//import
Route::post('api/import/save','ImportController@save');
//history
Route::get('api/history/get','HistoryController@get_history');
//settings
Route::get('api/settings/list','SettingsController@get_all');
Route::post('api/settings/save','SettingsController@save');
//-------------------------
//Front
Route::get('api/cats/front/shortlist','CatsController@shortlist');
Route::post('api/cats/front/list','CatsController@catslist');
Route::get('api/filters/front/filtersfilter','FiltersController@get_filtersfilter');
Route::post('api/compare/list','ProdsController@get_compare_prods');
Route::post('api/compare/catsfilters','CatsController@get_compare_filters');
Route::post('api/prods/detail','ProdsController@get_prods_detail');
Route::post('api/history/amazon','HistoryController@set_history_amazon');
Route::post('api/history/filters','HistoryController@set_history_filters');








//for testing
//Route::get('test','ProdsController@get_prods_with_filters_group');
//Route::get('test','SettingsController@get_all');
//Route::get('import','ImportController@save');
//Route::get('testapi','UsersController@get_all')->middleware('respapi');


Route::get('/{category}/{product}', function () {
    return view('template');
});
Route::get('/{category}/', function () {
    return view('template');
});