<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
use App\User;

class AuthController extends Controller
{  
  public function show(){
    return view('panel.signin');
  }

  public function signin(Request $request){
    if (Auth::attempt(['email' => $request->input('users_email'), 'password' => $request->input('users_password')]))
        {  
          $response['data'] = true;
          $response['message'] = ['type'=>'success', 'text'=>'Authorization successful'];
        }
        else{          
          $response['data'] = false;          
          $response['message'] = ['type'=>'danger', 'text'=>'Incorect username or password'];
        }
        return $response;        
    }
    public function info(Request $request){
      if (Auth::user()){
        $user = User::find(Auth::user()->id);
        $response['data']['id'] = $user->id;
        $response['data']['email'] = $user->email;
        $response['data']['role'] = $user->role->name;
      }
      else{
        $response['data'] = false;
      }      
      return $response;
    }

    public function signout(Request $request){      
      Auth::logout();
      $response['data'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Logout success'];      
      return $response;
    }

}

