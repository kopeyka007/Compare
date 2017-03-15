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
    $response['data'] = $cats;
    return $response;    
  }

  public function view($id){
    $cat = User::find($id);    
    if ($cat){
      $response['data'] = $cat;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
    }
    return $response;
  }
  
  public function save(Request $request){
    $cat = new Cats;
    $cat_id = $request->input('cats_id');
    //update
    if ($cat_id && $cat_id <> 0){
      $current = Cats::find($cat_id);
      if ($current){
        $current->cats_name = $request->input('cats_name');
        $current->cats_alias = $request->input('cats_alias');
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
      $cat->cats_name =  $request->input('cats_name');
      $cat->cats_alias = $request->input('cats_alias');      
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
    $cat = Cats::find($id);    
    if ($cat && $cat->delete()){
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Category deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
    }
    return $response;
  }

}
