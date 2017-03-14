<?php
namespace App\Http\Controllers;

use App\User;
use App\UsersTypes;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

//use Guzzle\Http\Client;

class UsersController extends Controller
{
  public function __construct()
  {
    //$this->middleware('RedirectIfAuthenticated');
  }
  public function show(){       
    return view('panel.users.show');
  }

  public function get_all(){
    $users = User::with('role')->get();
    $i=0;
    foreach ($users as $user) {
      $response['data'][$i]['id'] = $user->id;      
      $response['data'][$i]['email'] = $user->email;
      $response['data'][$i]['role'] = $user->role->name;      
      $i++;
    }
    return $response;
  }

  public function create(Request $request){
    $response['data']['users_types'] = UsersTypes::all();
    return $response;
  }

  public function update(Request $request){

  }

  public function delete(Request $request){

  }

  public function test(){    
    
  }
}
?>

