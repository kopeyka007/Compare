<?php

namespace App\Http\Controllers;
use App\Brands;
use App\Prods;
use App\Filters;
use Illuminate\Http\Request;
use Storage;


class ImportController extends Controller
{
  public function __construct()
  {    
  }
  public function show(){
    return view('panel.import');
  }
  public function import(){      
    $filename = storage_path('app/public/import/import.csv');
    $cats_id = 3;
    $groups_id = 6;
    $csv_array = $this->csvToArray($filename);
    foreach ($csv_array as $item)
    {      
      $fields = array_keys($item);
      for ($i=0; $i < count($fields) ; $i++) { 
        switch ($fields[$i]) {
          case 'Sr.no':              
            break;
          case 'Brand':
            $brands = $this->toggleBrands($item['Brand']);
            break;
          case 'Model Name':              
            $prod = $this->toggleProds($item['Model Name'], $item['Price'], $brands->brands_id, $cats_id);
            break;
          case 'Price':                            
            break;
          default:
            $filter = $this->toggleFilters($fields[$i], $item[$fields[$i]], $prod, $cats_id, $groups_id);
            break;
        }
      }
    }
  }
  
  private function csvToArray($filename){
      $header = null;
      $data = array();
      if ( ($handle = fopen($filename, 'r'))!== FALSE){
        $header = fgetcsv($handle, 1000, ',');
        foreach ($header as $key=>$value) {
          $header[$key] = trim($value);
        }
        while ( ($row = fgetcsv($handle, 1000, ',')) !== false)
        {            
          $data[] = array_combine($header, $row);
        }
        fclose($handle);
      }
      return $data;
  }

  private function toggleBrands($brands_name){    
    $current = Brands::whereRaw('LOWER(brands_name) = '."'".strtolower(trim($brands_name))."'")->first();        
    if ($current){
      return $current;
    }   
    else{
      $brand = new Brands;
      $brand->brands_name = trim($brands_name);
      $brand->save();
      return $brand;
    }
  }

  private function toggleProds($prods_name, $prods_price, $brands_id, $cats_id){
    $current = Prods::whereRaw('LOWER(prods_name) = '."'".strtolower(trim($prods_name))."'")
    ->where('cats_id', $cats_id)
    ->first();    
    if ($current){
      $current->prods_price = trim($prods_price);
      $current->save();
      return $current;
    }   
    else{
      $prod = new Prods;    
      $prod->cats_id = ($cats_id);
      $prod->prods_name = trim($prods_name);
      $prod->brands_id = $brands_id;
      $prod->prods_alias = $this->generate_alias(trim($prods_name));
      $prod->prods_price = trim($prods_price);
      $prod->prods_active = 1;
      $prod->save();
      return $prod;
    }
  }

  private function toggleFilters($filters_name, $filters_value, $prod, $cats_id, $groups_id){
    $filters = Filters::whereRaw('LOWER(filters_name) = '."'".strtolower(trim($filters_name))."'")    
    ->with('cats_id')->get();
    $current = false;
    foreach ($filters as $filter)
      foreach ($filter->cats_id as $cat) {
        if ($cat->cats_id == $cats_id){
          $current = $filter;
          break;
        } 
    }
    /*
    $current = Filters::with(['cats_id'=>function ($query) use ($cats_id){
      $query->where('cats.cats_id','=',$cats_id);
    }])
    ->whereRaw('LOWER(filters_name) = '."'".strtolower(trim($filters_name))."'")
    ->first();
    */
    dd($current);
    //var_dump($current);
    exit();
    if ($current){      
      $current->prods()->detach([$prod->prods_id]);
      $current->prods()->attach([$prod->prods_id=>['filters_value'=>$filters_value]]);
      return $current;
    }
    else{
      $filter = new Filters;
      $filter->filters_name = trim($filters_name);
      $filter->filters_type = 'text';
      $filter->groups_id = $groups_id;
      $filter->save();
      $filter->cats_id()->sync([$cats_id]);      
      $filter->prods()->detach([$prod->prods_id]);
      $filter->prods()->attach([$prod->prods_id=>['filters_value'=>$filters_value]]);
      return $filter;
    }
  }

  private function generate_alias($name){
    return str_replace([' '], '-', $name);
  }


}
