<?php

namespace App\Http\Controllers;
use App\Prods;
use Illuminate\Http\Request;
use Storage;

class ProdsController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.prods');
  }

  public function get_all(){
    $prods = Prods::with('filters_id')->
    with('features_id')->
    with('brands_id')->
    with('cats_id')
    ->get();    
    $response['data'] = $prods;
    return $response; 
  }

  public function view($id){
    $prod = Prods::find($id);    
    if ($prod){
      $response['data'] = $prod;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
    }
    return $response;
  }
  
  public function save(Request $request){
    //var_dump($request->input('prods_price'));
    //exit();
    $prod = new Prods;
    $prods_id = $request->input('prods_id');
    //update
    if ($prods_id && $prods_id <> 0){
      $current = Prods::find($prods_id);
      if ($current){
        $current->cats_id = $request->input('cats_id')['cats_id'];
        $current->brands_id = $request->input('brands_id')['brands_id'];        
        $current->prods_name = $request->input('prods_name');        
        $current->prods_alias = $request->input('prods_alias');        
        $file = ($request->file) ? asset('storage/'.$request->file->store('prods')):0;
        //delete file
        if ($current->prods_foto !== 0 && $current->prods_foto !== $file){
          Storage::delete(stristr($current->prods_foto, 'prods'));    
        }
        $current->prods_foto = $file;                
        $current->prods_amazon = $request->input('prods_amazon');
        $current->prods_price = ($request->input('prods_price') == 'null')?null:$request->input('prods_price');        
        $current->prods_active = ($request->input('prods_active') == 'true')?1:0;
        $filters = $request->input('filters');
        $features = $request->input('features');
        if ($current->save()){          
          $this->set_relation_filters($prods_id, $filters);
          $this->set_relation_features($prods_id, $features);
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Product saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
      }
        
    }
    //create
    else
    {      
      $prod->cats_id = $request->input('cats_id')['cats_id'];        
      $prod->brands_id = $request->input('brands_id')['brands_id'];        
      $prod->prods_name = $request->input('prods_name');        
      $prod->prods_alias = $request->input('prods_alias');        
      $file = ($request->file) ? asset('storage/'.$request->file->store('prods')):0;
      $prod->prods_foto = $file;
      $prod->prods_amazon = $request->input('prods_amazon');        
      $prod->prods_price = ($request->input('prods_price') == 'null')?null:$request->input('prods_price');
      $prod->prods_active = ($request->input('prods_active') == 'true')?1:0;    
      $filters = $request->input('filters');
      $features = $request->input('features');
      if ($prod->save()){
        $this->set_relation_filters($prod->prods_id, $filters);
        $this->set_relation_features($prod->prods_id, $features);
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Product created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $prod = Prods::find($id);    
    if ($prod && $prod->delete()){
      if ($prod->prods_foto !== 0)
        Storage::delete(stristr($prod->prods_foto, 'prods'));
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Product deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
    }
    return $response;
  }
  //relations with filters
  private function set_relation_filters($prods_id, $filters){
    if (count($filters)){
      $prod = Prods::find($prods_id);
      foreach ($filters as $item=>$value) {
        $arr[$item]['filters_value'] = $value;
      }
      $prod->filters_id()->sync($arr);    
    }
  }
  //relations with features
  private  function set_relation_features($prods_id, $features){
    if (count($features)){
      $prod = Prods::find($prods_id);
      foreach ($features as $item=>$value) {
        $arr[$item]['features_value'] = $value;
      }
      $prod->features_id()->sync($arr);      
    }
  }

  //Front
  public function get_prods_with_filters_group($ids){
    //$prods = Prods::with('filters_id', 'filters_id.groups')->find([4]);
    //$ids = [0=>4, 1=>5];
    $prods = Prods::with('filters_id', 'filters_id.groups')->find($ids);
    
    foreach ($prods as $prod) {
      foreach ($prod->filters_id as $filter) {
        $arr[$filter->groups->groups_name][] = $filter;
        unset($filter->groups);
      }
      $prod['groups'] = $arr;
      //$arr[$prod] = $arr;
      //$arr['groups'] = $groups;
      unset($prod->filters_id);
    }
    //return $arr;
    return $prods;
  }

  public function get_compare_prods(Request $request){    
    $url = $request->input('url');
    $url = str_replace('compare/', '', $url);
    $aliases = explode('-vs-', $url);    
    for ($i=0; $i < count($aliases) ; $i++) {
      $alias = str_replace('/', '', $aliases[$i]);
      $prod = Prods::where('prods_alias', $alias)->first();
      $ids[] = $prod->prods_id;
    }    
    $response['data'] = $this->get_prods_with_filters_group($ids);
    return $response;
  }

  


}
