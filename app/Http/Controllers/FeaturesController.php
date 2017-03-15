<?php

namespace App\Http\Controllers;
use App\Features;
use Illuminate\Http\Request;

class FeaturesController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.features');
  }

  public function get_all(){
    $features = Features::all();    
    $response['data'] = $features;
    return $response;    
  }

  public function view($id){
    $feature = Features::find($id);    
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
    $feature = new Features;
    $feature_id = $request->input('feature_id');
    //update
    if ($feature_id && $feature_id <> 0){
      $current = Prods::find($feature_id);
      if ($current){
        $current->cats_id = $request->input('feature_id');        
        $current->features_name = $request->input('features_name');        
        $current->features_icon = $request->input('features_icon');        
        $current->features_desc = $request->input('features_desc');                
        $current->features_units = $request->input('features_units');        
        $current->features_around = $request->input('features_around');        
        $current->features_norm = $request->input('features_norm');
        if ($current->save()){
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
      $feature->cats_id = $request->input('feature_id');        
      $feature->features_name = $request->input('features_name');        
      $feature->features_icon = $request->input('features_icon');        
      $feature->features_desc = $request->input('features_desc');                
      $feature->features_units = $request->input('features_units');        
      $feature->features_around = $request->input('features_around');        
      $feature->features_norm = $request->input('features_norm');   
      if ($feature->save()){
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
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Feature deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Feature not found'];
    }
    return $response;
  }


}
