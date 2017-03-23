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
        if ($current->save()){
          $response['data'] = true;          
          $response['message'] = ['type'=>'success', 'text'=>'Currency saved'];
        }
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Currency not found'];
      } 
    }
    //create
    else
    { 
      $currency->currencies_name = $request->input('currencies_name');
      $currency->currencies_symbol = $request->input('currencies_symbol');
      if ($currency->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Currency created'];
      }
      else{
        $response['data'] = false;          
        $response['message'] = ['type'=>'danger', 'text'=>'Error']; 
      }    
    }    
    return $response;
  }

  public function delete($id){
    $currency = Currencies::find($id);    
    if ($currency && $currency->delete()){      
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Currency deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Currency not found'];
    }
    return $response;
  }
}
