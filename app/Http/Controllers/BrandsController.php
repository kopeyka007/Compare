<?php

namespace App\Http\Controllers;
use App\Brands;
use Illuminate\Http\Request;

class BrandsController extends Controller
{
    public function __construct()
    {    
    }

    public function show()
    {       
        return view('panel.brands');
    }

    public function get_all(){    
        $brands = Brands::with('cats_id')
        ->whereHas('cats_id',function($q){
          $q->access();
        })
        ->get();
        $response['data'] = $brands;
        return $response;    
    }
  
    public function view($id){
        $brand = Brands::find($id);    
        if ($brand)
        {
            $response['data'] = $brand;            
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Brand not found'];
        }
        return $response;
    }
  
    public function save(Request $request)
    {
        $brand = new Brands;
        $brand_id = $request->input('brands_id');
        //update
        if (! empty($brand_id))
        {
            $brand = Brands::find($brand_id);
        }
        if ( ! empty($brand))
        { 
            $brand->brands_name =  $request->input('brands_name');
            $brand->brands_alias =  $request->input('brands_alias');      
            $brand->cats_id = $request->input('cats_id')['cats_id'];
            if ($brand->save())
            {
                $response['data'] = true;          
                $response['message'] = ['type'=>'success', 'text'=>'Brand saved'];
            }
        }
        return $response;
    }

    public function delete($id)
    {
        $brand = Brands::find($id);    
        if ($brand && $brand->delete())
        {
            $response['data']['type'] = true;      
            $response['message'] = ['type'=>'success', 'text'=>'Brand deleted'];      
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Brand not found'];
        }
        return $response;
    }
}
