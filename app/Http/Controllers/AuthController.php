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
    //var_dump($request->input('users_email'));
     /*
     $this->validate($request, [
        'users_email' => 'required|max:255',
      ]);
      */

     //var_dump($this->validate()->errors()->all());
     ///var_dump(ViewErrorBag::errors);

      /*
      $validator = Validator::make($request->all(), [
            'users_email' => 'required|max:5',            
      ]);
      if ($validator->fails()) {
            //return redirect('post/create')->withErrors($validator)->->withInput();
      }
      var_dump($validator->errors()->all());
      */
      /*
      $validator = Validator::make($request->all(), [
            'users_email' => 'required|max:50',            
      ]);
      if ($validator->fails())
        {
            return 'tak';
        }
        return 'ni';
        //return Response::json(array('success' => true), 200);
        */
      /*if (Auth::attempt(['email' => $email, 'password' => $password])) {
        echo "tak";
      };
      else echo "ni";*/
      //var_dump(bcrypt('1234'));
      //return redirect()->intended('dashboard');
      //Auth::logout();
      //var_dump($request->input('users_password'));

      if (Auth::attempt(['email' => $request->input('users_email'), 'password' => $request->input('users_password')]))
      //if (Auth::attempt(['email' => 'div-art@com', 'password' => $request->input('users_password')]))
      //if (Auth::attempt(['email' => 'div-art@com', 'password' => '1234']))
        {
            //echo "tak";            
            //return redirect()->intended('');            
            $user = Auth::user();
            var_dump($user);
            Auth::logout();
        }
        else{
          echo "no";
        }
    }
}

