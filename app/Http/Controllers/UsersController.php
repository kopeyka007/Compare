<?php
namespace App\Http\Controllers;
//namespace App\Http\Middleware;

use App\Http\Controllers\Controller;
use Auth;

class UsersController extends Controller
{
  public function __construct()
  {
    //$this->middleware('RedirectIfAuthenticated');
  }
  public function show(){
    //var_dump($parameters);
    //Auth::logout();
    return 'test';
  }
}
