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
    $features = Features::with('cats_id')
    ->whereHas('cats_id',function($q){
      $q->access();
    })
    ->get();
    SettingsController::set_config_s3();
    foreach ($features as $feature) {
      $feature->short_foto = $feature->features_icon;
      $feature->features_icon = empty($feature->features_icon)?asset('images/nofoto.png'):Storage::disk('s3')->url($feature->features_icon);
    }
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
    $feature = new Features;
    $features_id = $request->input('features_id');
    //update
    if ($features_id && $features_id <> 0){
      $current = Features::find($features_id);
      if ($current){        
        $current->features_id = $features_id;        
        $current->features_name = $request->input('features_name');               
        if ($request->file){
            try {
                $current->features_icon = $this->upload_s3($request->file);
            } 
            catch(S3 $e) {                           
                $response['data'] = false;          
                $response['message'] = ['type'=>'danger', 'text'=>$e->getMessage()]; 
                return $response;
            }
        }
        else{          
            if (empty($request->input('features_icon'))){
                SettingsController::set_config_s3();
                Storage::disk('s3')->delete($current->features_icon);
                $current->features_icon = '';
            }
            else{
              $current->features_icon = $request->input('short_foto');  
            }
        }
        $current->features_desc = $request->input('features_desc');                
        $current->features_units = $request->input('features_units');        
        $current->features_around = $request->input('features_around');        
        $current->features_norm = $request->input('features_norm');
        $current->features_rate = $request->input('features_rate');
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
      $feature->features_desc = $request->input('features_desc');                
      $feature->features_units = $request->input('features_units');        
      $feature->features_around = $request->input('features_around');        
      $feature->features_norm = $request->input('features_norm');
      $feature->features_rate = $request->input('features_rate');
      if ($request->file){
            try {
                $feature->features_icon = $this->upload_s3($request->file);
            } 
            catch(S3 $e) {                           
                $response['data'] = false;          
                $response['message'] = ['type'=>'danger', 'text'=>$e->getMessage()]; 
                return $response;
            }
        }
        else{
          $feature->features_icon = $request->input('short_foto');
        }
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
      if (!empty($feature->features_icon)){
          SettingsController::set_config_s3();
          Storage::disk('s3')->delete($feature->features_icon);
      }
      //delete relations       
      $feature->prods()->detach();
      $feature->cats_id()->detach();
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
  
  private function upload_s3($file, $current = false){
    SettingsController::set_config_s3();
    $s3 = Storage::disk('s3');        
    if (!empty($current->features_icon)){
      if ($s3->exists($current->features_icon)){          
        $s3->delete($current->features_icon);
      }  
    }    
    $filename = rand(100000, 999999).'_'.time().'.'.$file->getClientOriginalExtension();    
    $filepath = 'features/'.$filename;
    $s3->put('/'.$filepath, file_get_contents($file), 'public');    
    return $filepath;
  }


}
