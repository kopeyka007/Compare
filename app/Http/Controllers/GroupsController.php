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
  
  public function view($id){
    $group = Groups::find($id);    
    if ($group){
      $response['data'] = $group;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Group not found'];
    }
    return $response;
  }
  
  public function save(Request $request){
    $group = new Groups;
    $groups_id = $request->input('groups_id');
    //update
    if ($groups_id && $groups_id <> 0){
      $current = Groups::find($groups_id);
      if ($current){
        $current->groups_name = $request->input('groups_name');        
        if ($current->save()){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Group saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Group not found'];
      }
    }
    //create
    else
    {
      $group->groups_name =  $request->input('groups_name');
      if ($group->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Group created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $group = Brands::find($id);    
    if ($group && $group->delete()){
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Group deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Group not found'];
    }
    return $response;
  }


}
