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
  
  
      //$csv_file = fopen('import_csv.csv','r');
    //var_dump(fopen(public_path().'\import\import_csv.csv','r'));
    //$handle = fopen(public_path().'\import\import_csv.csv','r');
      /*
      while (($data = fgetcsv($handle, 1000, ',')) !==FALSE){          
          for ($i=0; $i < count($data); $i++) { 
            echo $data[$i]."<br>";
          }          
        }
        */
    //fclose($handle);
  
  
  public function import(){      
      $filename = storage_path('app/public/import/import.csv');
      /*
      $handle = fopen($filename, 'r');      
      $header = fgetcsv($handle, 1000, ',');
      while ($data = fgetcsv($handle, 1000, ',')){
          echo $data[0]."<br>";
      }
      */
      $cats_id = 3;
      $groups_id = 6;
      $csv_array = $this->csvToArray($filename);
      
      foreach ($csv_array as $item)
      {
        //echo $item['Brand'];
        //var_dump(array_keys($item));
        //$brands = $this->togleBrands($item['Brand']);
        //$prod = $this->togleProds($item['model name'], $item['price'], $brands->brands_id, $cats_id);
        //var_dump(array_keys($item['Brand']));
        $fields = array_keys($item);
        for ($i=0; $i < count($fields) ; $i++) { 
          switch ($fields[$i]) {
            case 'Sr.no':              
              break;
            case 'Brand':
              $brands = $this->togleBrands($item['Brand']);
              break;
            case 'Model Name':              
              $prod = $this->togleProds($item['Model Name'], $item['Price'], $brands->brands_id, $cats_id);
              break;
            case 'Price':                            
              break;
            default:
              $filter = $this->togleFilters($fields[$i], $item[$fields[$i]], $prod->prods_id, $cats_id, $groups_id);
              //print_r($filter->filters_id);

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



  private function togleBrands($brands_name){    
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

  private function togleProds($prods_name, $prods_price, $brands_id, $cats_id){
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

  private function togleFilters($filters_name, $filters_value, $prods_id, $cats_id, $groups_id){    
    $current = Filters::whereRaw('LOWER(filters_name) = '."'".strtolower(trim($filters_name))."'")
    ->where('groups_id', $groups_id)
    ->first();        
    if ($current){
      return $current;
    }   
    else{
      $filter = new Filters;
      $filter->filters_name = trim($filters_name);
      $filter->filters_type = 'text';
      $filter->groups_id = $groups_id;
      $filter->save();
      $filter->cats_id()->sync([$cats_id]);
      $filter->prods()->sync([$prods_id=>['filters_value'=>'test']]);
      return $filter;
    }
  }

  private function generate_alias($name){
    return str_replace([' '], '-', $name);
  }


}
