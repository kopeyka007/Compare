<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;


class UsersController extends Controller
{
  public function __construct()
  {
    //$this->middleware('RedirectIfAuthenticated');
  }
  public function show(){    
    
    return 'test';
  }
}
