<?php

namespace App\Http\Controllers;
use App\Filters;
use App\Groups;
use Illuminate\Http\Request;

class FiltersController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.filters');
  }

  public function get_all(){
    $filters = Filters::with('groups_id')->get();    
    $response['data'] = $filters;
    return $response;    
  }

  public function view($id){
    $filter = Filters::find($id);    
    if ($filter){
      $response['data'] = $filter;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Filter not found'];
    }
    return $response;
  }
  
  public function save(Request $request){
    $filter = new Filters;
    $filter_id = $request->input('id');
    //update
    if ($filter_id && $filter_id <> 0){
      $current = Filters::find($filter_id);
      if ($current){
        $current->groups_id = $request->input('groups_id');        
        $current->filters_name = $request->input('filters_name');        
        $current->filters_alias = $request->input('filters_alias');        
        $current->filters_type = $request->input('filters_type');        
        $current->filters_filter = $request->input('filters_filter');        
        if ($current->save()){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Filter saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Filter not found'];
      }
        
    }
    //create
    else
    {      
      $filter->groups_id = $request->input('groups_id');        
      $filter->filters_name = $request->input('filters_name');        
      $filter->filters_alias = $request->input('filters_alias');        
      $filter->filters_type = $request->input('filters_type');        
      $filter->filters_filter = $request->input('filters_filter');    
      if ($filter->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Filter created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $filter = Filters::find($id);    
    if ($filter && $filter->delete()){
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Filter deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Filter not found'];
    }
    return $response;
  }

  public function get_all_groups(){
    $groups = Groups::all();    
    $response['data'] = $groups;
    return $response;   
  }


}
