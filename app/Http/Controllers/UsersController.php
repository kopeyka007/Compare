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
      $response['data'][$i]['type'] = ['id'=>$user->role->id, 'name'=>$user->role->name];      
      $i++;
    }
    return $response;
  }

  public function get_users_types(){
    $response['data'] = UsersTypes::all();
    return $response;
  }

  public function view($id){
    $user = User::find($id);    
    if ($user){
      $response['data'] = $user;
      $response['data']['type'] = ['id'=>$user->role->id, 'name'=>$user->role->name];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
    }
    return $response;
  }
  
  public function save(Request $request){
    $user = new User;
    $user_id = $request->input('id');
    //update
    if ($user_id){
      $current = User::find($user_id);
      if ($current){
        $current->email = $request->input('email');
        $current->type_id = $request->input('type')['id'];
        if ($current->save()){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'User saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
      }
        
    }
    //create
    else
    {
      $user->email =  $request->input('email');
      $user->password = bcrypt($request->input('password'));
      $user->type_id = $request->input('type')['id'];            

      if ($user->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'User created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $user = User::find($id);    
    if ($user && $user->delete()){
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'User deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
    }
    return $response;
  }
}
?>

