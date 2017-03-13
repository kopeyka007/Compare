<?php
namespace App\Http\Controllers;
//namespace App\Http\Middleware;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
  public function __construct()
  {
    //$this->middleware('RedirectIfAuthenticated');
  }
  public function show($parameters){
    var_dump($parameters);
    //return 'test';
  }
}
