<?php

namespace App\Http\Controllers;
use App\Cats;
use Illuminate\Http\Request;

class CatsController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.cats');
  }

  public function get_all(){
    $cats = Cats::all();
    /*$i=0;
    foreach ($users as $user) {
      $response['data'][$i]['id'] = $user->id;      
      $response['data'][$i]['email'] = $user->email;
      $response['data'][$i]['type'] = ['id'=>$user->role->id, 'name'=>$user->role->name];      
      $i++;
    }*/
    return $cats;
    //return $response;
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
    $cat = new Cats;
    $cat_id = $request->input('id');
    //update
    if ($cat_id){
      $current = Cats::find($cat_id);
      if ($current){
        $current->email = $request->input('email');
        $current->type_id = $request->input('type')['id'];
        if ($current->save()){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Category saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
      }
        
    }
    //create
    else
    {
      $cat->email =  $request->input('email');
      $cat->password = bcrypt($request->input('password'));
      $cat->type_id = $request->input('type')['id'];
      if ($cat->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Category created'];
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
