<?php

namespace App\Http\Controllers;
use App\Groups;
use Illuminate\Http\Request;

class GroupsController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.groups');
  }

  public function get_all(){
    $groups = Groups::all();    
    $response['data'] = $groups;
    return $response;    
  }
}
