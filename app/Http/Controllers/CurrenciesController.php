<?php

namespace App\Http\Controllers;
use App\Currencies;
use Illuminate\Http\Request;
class CurrenciesController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.currencies');
  }

  public function get_all(){
    $currencies = Currencies::all();    
    $response['data'] = $currencies;
    return $response;    
  }
  
  public function save(Request $request){             
    $currency = new Currencies;
    $currencies_id = $request->input('currencies_id');
    //update
    if ($currencies_id && $currencies_id <> 0){
      $current = Currencies::find($currencies_id);
      if ($current){
        $current->currencies_name = $request->input('currencies_name');        
        $current->currencies_symbol = $request->input('currencies_symbol');        
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
      $file = ($request->file) ? asset('storage/'.$request->file->store('features')):'';
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
}
