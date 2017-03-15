<?php

namespace App\Http\Controllers;
use App\Prods;
use Illuminate\Http\Request;

class ProdsController extends Controller
{
  public function __construct()
  {    
  }

  public function show(){       
    return view('panel.prods');
  }

  public function get_all(){
    $prods = Prods::all();    
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
    $prod = new Prods;
    $prod_id = $request->input('id');
    //update
    if ($prod_id && $prod_id <> 0){
      $current = Prods::find($prod_id);
      if ($current){
        $current->cats_id = $request->input('cats_id');        
        $current->brands_id = $request->input('brands_id');        
        $current->prods_name = $request->input('prods_name');        
        $current->prods_alias = $request->input('prods_alias');        
        //$current->prods_foto = $request->input('prods_foto');        
        $current->prods_amazon = $request->input('prods_amazon');        
        $current->prods_price = $request->input('prods_price');        
        $current->prods_active = $request->input('prods_active');
        if ($current->save()){
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
      $prod->cats_id = $request->input('cats_id');        
      $prod->brands_id = $request->input('brands_id');        
      $prod->prods_name = $request->input('prods_name');        
      $prod->prods_alias = $request->input('prods_alias');        
      //$prod->prods_foto = $request->input('prods_foto');        
      $prod->prods_amazon = $request->input('prods_amazon');        
      $prod->prods_price = $request->input('prods_price');        
      $prod->prods_active = $request->input('prods_active');    
      if ($prod->save()){
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
      $response['data']['type'] = true;      
      $response['message'] = ['type'=>'success', 'text'=>'Product deleted'];      
    }
    else{
      $response['data'] = false;          
      $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
    }
    return $response;
  }


}
