<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BrandsController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.brands');
  }

}
