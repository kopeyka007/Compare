<?php

namespace App\Http\Controllers;
use App\Features;
use App\Cats;
use App\CatsFeatures;
use Illuminate\Http\Request;
use Storage;
class FeaturesController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.features');
  }

  public function get_all(){
    $features = Features::with('cats_id')->get();
    //$features->features_icon = /($features->features_icon);
    //print_r($fea);
    $response['data'] = $features;
    return $response;    
  }

  public function view($id){
    $feature = Features::with('cats_id')->find($id);
    if ($feature){
      $response['data'] = $feature;            
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Feature not found'];
    }
    return $response;
  }
  
  public function save(Request $request){         
    //var_dump($request->file);
    //exit();
    $feature = new Features;
    $features_id = $request->input('features_id');
    //update
    if ($features_id && $features_id <> 0){
      $current = Features::find($features_id);
      if ($current){        
        $current->features_id = $features_id;        
        $current->features_name = $request->input('features_name');        
        $file = ($request->file) ? asset('storage/'.$request->file->store('features')):0;
        //delete file
        if ($current->features_icon !== 0 && $current->features_icon !== $file){
          Storage::delete(stristr($current->features_icon, 'features'));    
        }        
        $current->features_icon = $file;
        $current->features_desc = $request->input('features_desc');                
        $current->features_units = $request->input('features_units');        
        $current->features_around = $request->input('features_around');        
        $current->features_norm = $request->input('features_norm');
        $cats_id = $request->input('cats_id')['cats_id'];
        if ($current->save() && $this->set_relation_category($cats_id, $features_id)){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Feature saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Feature not found'];
      } 
    }
    //create
    else
    { 
      $feature->features_name = $request->input('features_name');
      $file = ($request->file) ? asset('storage/'.$request->file->store('features')):0;
      $feature->features_icon = $file;
      $feature->features_desc = $request->input('features_desc');                
      $feature->features_units = $request->input('features_units');        
      $feature->features_around = $request->input('features_around');        
      $feature->features_norm = $request->input('features_norm');
      $cats_id = $request->input('cats_id')['cats_id'];
      if ($feature->save() && $this->set_relation_category($cats_id, $feature->features_id)){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Feature created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $feature = Features::find($id);    
    if ($feature && $feature->delete()){
      if ($feature->features_icon !== 0)
        Storage::delete(stristr($feature->features_icon, 'features'));
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Feature deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Feature not found'];
    }
    return $response;
  }

  public function set_relation_category($cats_id, $features_id){
    $features = Features::find($features_id);
    if ($features->cats_id()->sync([$cats_id])) return true;    
  }


}
