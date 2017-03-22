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
    $filters = Filters::with('groups_id')->with('cats_id')->get();    
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
    $filters_id = $request->input('filters_id');
    //update
    if ($filters_id && $filters_id <> 0){
      $current = Filters::find($filters_id);
      if ($current){        
        //if created new groups filters
        if ($request->input('groups_id')['groups_id'] == 0 && $request->input('groups_name') !== ''){
          $groups = new Groups;
          $groups->groups_name = $request->input('groups_name');
          $groups->save();
          $current->groups_id = $groups->groups_id;
        }
        else{
          $current_group = Groups::find($request->input('groups_id')['groups_id']);
          if ($current_group){
            $current_group->groups_name = $request->input('groups_id')['groups_name'];
            $current_group->save();
            $current->groups_id = $current_group->groups_id;
          }
        }
        $current->filters_name = $request->input('filters_name');        
        $current->filters_alias = $request->input('filters_alias');        
        $current->filters_type = $request->input('filters_type');        
        $current->filters_filter = $request->input('filters_filter');        
        $current->filters_units = $request->input('filters_units');        
        $cats_id = $request->input('cats_id')['cats_id'];
        if ($current->save() && $this->set_relation_category($cats_id, $filters_id)){
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
      //if created new groups filters
      if ($request->input('groups_id')['groups_id'] == 0 && $request->input('groups_name') !== ''){
        $groups = new Groups;
        $groups->groups_name = $request->input('groups_name');
        $groups->save();
        $filter->groups_id = $groups->groups_id;
      }
      else{
        $current_group = Groups::find($request->input('groups_id')['groups_id']);
        if ($current_group){
          $current_group->groups_name = $request->input('groups_id')['groups_name'];
          $current_group->save();
          $filter->groups_id = $current_group->groups_id;
        }
      }
      $filter->filters_name = $request->input('filters_name');        
      $filter->filters_alias = $request->input('filters_alias');        
      $filter->filters_type = $request->input('filters_type');        
      $filter->filters_filter = $request->input('filters_filter');
      $filter->filters_units = $request->input('filters_units');
      $cats_id = $request->input('cats_id')['cats_id'];    
      if ($filter->save() && $this->set_relation_category($cats_id, $filter->filters_id)){
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
      //delete relations       
      $filter->prods()->detach();
      $filter->cats_id()->detach();
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Filter deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Filter not found'];
    }
    return $response;
  }

  public function set_relation_category($cats_id, $filters_id){
    $filters = Filters::find($filters_id);
    if ($filters->cats_id()->sync([$cats_id])) return true;    
  }

  public function get_all_groups(){
    $groups = Groups::all();    
    $response['data'] = $groups;
    return $response;   
  }

  //Front

  public function get_filtersfilter(){
    $filters = Filters::with('prods')->where('filters_filter',1)->get();
    foreach ($filters as $filter) {
      $arr = array();
      foreach ($filter->prods as $prod) {        
        $arr[] = $prod->pivot->filters_value;
      }      
      unset($filter->prods);
      $filter['filter_values'] = array_unique($arr);
    }    
    $response['data'] = $filters;
    return $response;
  }


}
