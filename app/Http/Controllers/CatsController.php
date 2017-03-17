<?php

namespace App\Http\Controllers;
use App\Cats;
use App\Prods;
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
    $cats = Cats::with('features')->get();    
    $response['data'] = $cats;
    return $response;    
  }

  public function view($id){
    $cat = Cats::with('features')->find($id);    
    if ($cat){
      $response['data'] = $cat;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
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
      $response['data'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Category deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
    }
    return $response;
  }

  public function get_filters($id){    
    $cat = Cats::find($id)->filters;
    //$cat = Cats::with('filters', 'filters.groups_id')->find($id);    
    if ($cat){
      $response['data'] = $cat;
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
    }
    return $response;
  }

  public function get_filters_groups($id){    
    //$cat = Cats::find($id);    
    $cats = Cats::with('filters.groups')->find($id);
    $filters = $cats->filters;
    foreach ($cats->filters as $filter) {      
      $groups[$filter->groups->groups_name][] = $filter;
    }
    //return $cats->filters;
    return $groups;
    //return $filters;

    //return $response;
  }

  public function get_features($id){
    $cat = Cats::find($id);
    if ($cat){
      $response['data'] = $cat->features;
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
    }
    return $response; 
  }
  //Front ---------------------
  public function shortlist(){    
    $cats = Cats::with('prods')
    ->with('prods.brands_id')
    ->get();
    return $cats;    
  }

  public function get_compare_filters(Request $request){
    $url = $request->input('url');
    /*
    $url = str_replace('compare/', '', $url);
    $aliases = explode('-vs-', $url);    
    for ($i=0; $i < count($aliases) ; $i++) {
      $alias = str_replace('/', '', $aliases[$i]);
      $prod = Prods::where('prods_alias', $alias)->first();
      $ids[] = $prod->cats_id;
    }
    */
    $ids = [0=>1, 1=>2];
    $response['data'] = $this->get_cats_filters($ids);
    return $response;
  }

  private function get_cats_filters($ids){
    $cats = Cats::with('filters.groups')->find($ids);    
    foreach ($cats as $cat) {      
      foreach ($cat->filters as $filter) {
        $groups[$filter->groups->groups_name][] = $filter;
      }
      $cat['groups'] = $groups[$filter->groups->groups_name][] = $filter;
    }
    //return $cats->filters;
    //return $groups;
    return $cats;
  }
}
