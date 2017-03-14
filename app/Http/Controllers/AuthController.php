<?php
namespace App\Http\Controllers;

use App\Http\Requests;
use Illuminate\Http\Request;
//use Illuminate\View\Middleware\ShareErrorsFromSession;
//use Illuminate\Support\MessageBag;
use Validator;
//use Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Auth;
//use Auth;

class AuthController extends Controller
{  
  public function show(){
    return view('panel.signin');
  }
  public function signin(Request $request){
      if (Auth::attempt(['email' => $request->input('users_email'), 'password' => $request->input('users_password')]))
        {  
            //$user = Auth::user();
            //return $user;
            return true;
        }
        else{
          return false;
        }
        
    }
    public function info(Request $request){
      return Auth::user();
    }

    public function signout(Request $request){
      Auth::logout();
    }

}

