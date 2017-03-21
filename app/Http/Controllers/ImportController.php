<?php

namespace App\Http\Controllers;
use App\Brands;
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
      $array = $this->csvToArray($filename);
      print_r($array);
      
  }
  
  private function csvToArray($filename){
      $header = null;
      $data = array();
      if ( ($handle = fopen($filename, 'r'))!== FALSE){
        while ( ($row = fgetcsv($handle, 1000, ',')) !== false)
        {
            if (!$header)
                $header = $row;
            else
                $data[] = array_combine($header, $row);
        }
        fclose($handle);
      }
      return $data;
  }
}
