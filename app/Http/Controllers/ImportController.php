<?php

namespace App\Http\Controllers;
use App\Brands;
use App\Groups;
use App\Prods;
use App\Filters;
use App\Currencies;
use App\Settings;
use Illuminate\Http\Request;
use Storage;
use DB;


class ImportController extends Controller
{
    public $message = ['prods'=>0];

    public function __construct()
    {    
    }
    
    public function show()
    {
        return view('panel.import');
    }

    public function save(Request $request)
    {
        $cats_id = $request->input('cats_id')['cats_id'];    
        if ($cats_id && $cats_id !== 0)
        {
            if ($request->file)
            {
                $or_ext = $request->file->getClientOriginalExtension();        
                if ($or_ext == 'csv')
                {
                    $request->file->storeAs('import','import.csv');
                    $filename = storage_path('app/public/import/import.csv');
                    $groups_name = 'import';
                    $group = $this->toggleGroups($groups_name);
                    $csv_array = $this->csvToArray($filename);
                    DB::beginTransaction();
                    foreach ($csv_array as $item)
                    {      
                        $fields = array_keys($item);
                        $not_filters = ['Sr.no','Brand','Slug','Model','Name', 'Price', 'Link to Amazon', 'Photo'];
                        $link_to_amazon = (isset($item['Link to Amazon'])) ? $item['Link to Amazon'] : null;
                        $prods_foto = (isset($item['Photo'])) ? $item['Photo'] : null;
                        $price = (isset($item['Price']) && !empty($item['Price'])) ? $item['Price'] : 0;                        
                        $prods_name = (isset($item['Model'])) ? trim($item['Model']) : '';
                        $prods_name = (isset($item['Name'])) ? trim($item['Name']) : $prods_name;
                        if (!empty($prods_name))
                        {
                            $brands = $this->toggleBrands($item['Brand'], $cats_id);
                            $prod = $this->toggleProds($item['Model'], $price, $brands, $cats_id, $link_to_amazon, $prods_foto);
                            for ($i = 0; $i < count($fields); $i++)
                            {
                                if(!in_array($fields[$i], $not_filters) && !empty(trim($fields[$i])))
                                {                                
                                    $filter = $this->toggleFilters($fields[$i], $item[$fields[$i]], $prod, $cats_id, $group->groups_id);
                                }
                            }
                        }
                    }
                    DB::commit();    
                    //Storage::delete('import.csv', 'import');
                    //$message = 'Updated prods - '. $this->message['prods'];
                    $response['data']['prods'] = $this->message['prods'];          
                    $response['message'] = ['type'=>'success', 'text'=>'Import success'];    
                }
                else
                {
                  $response['data'] = false;          
                  $response['message'] = ['type'=>'danger', 'text'=>'Chose CSV file'];    
                }
            }
            else
            {
              $response['data'] = false;          
              $response['message'] = ['type'=>'danger', 'text'=>'Chose file'];
            }
        }
        else
        {
          $response['data'] = false;          
          $response['message'] = ['type'=>'danger', 'text'=>'Chose category'];
        }        
        return $response;
  }
  
    private function csvToArray($filename)
    {
        $header = null;
        $data = array();
        if ( ($handle = fopen($filename, 'r'))!== FALSE)
        {
            $header = fgetcsv($handle, 1000, ',');
            foreach ($header as $key=>$value)
            {
                $header[$key] = trim($value);
            }
            while ( ($row = fgetcsv($handle, 1000, ',')) !== false)
            {
                $row_np = array_map(function($value)
                    {
                        return $this->handle_string($value);
                    }, $row);
                $data[] = array_combine($header, $row_np);
            }
            fclose($handle);
        }
        return $data;
  }

    private function toggleGroups($groups_name)
    {    
        $current = Groups::where('groups_name', $groups_name)->first();        
        if ($current)
        {
            return $current;
        }   
        else
        {
            $group = new Groups;
            $group->groups_name = trim($groups_name);
            $group->save();
            return $group;
        }
    }

    private function toggleBrands($brands_name, $cats_id)
    {    
        $current = Brands::whereRaw('LOWER(brands_name) = '."'".strtolower(trim($brands_name))."'")
        ->where('cats_id', $cats_id)
        ->first();        
        if ($current)
        {      
            return $current;
        }   
        else
        {      
            $brand = new Brands;
            $brand->brands_name = trim($brands_name);
            $brand->brands_alias = $this->generate_alias_brands(trim($brands_name));
            $brand->cats_id = $cats_id;
            $brand->save();            
            return $brand;
        }
    }

    private function toggleProds($prods_name, $prods_price, $brands, $cats_id, $prods_amazon, $prods_foto)
    {   
        $current = Prods::whereRaw('LOWER(prods_name) = '."'".strtolower(trim($prods_name))."'")
        ->where('cats_id', $cats_id)
        ->where('brands_id', $brands->brands_id)
        ->first();    
        if ($current)
        {            
            if (!empty($prods_price))
            {
                $current->prods_price = trim($prods_price);
            }
            if (!empty($prods_amazon))
            {
                $current->prods_amazon = trim($prods_amazon);
            }
            if (!empty($prods_foto))
            {
                $current->prods_foto = trim($prods_foto);
            }
            $current->save();
            $this->message['prods']++;
            return $current;
        }   
        else
        {
            $currency_default = Currencies::where('currencies_default', 1)->first();    
            $prod = new Prods;    
            $prod->cats_id = ($cats_id);
            $prod->prods_name = trim($prods_name);
            $prod->brands_id = $brands->brands_id;
            $prod->prods_alias = $this->generate_alias_prods(trim($prods_name));
            $prod->prods_full_alias = $brands->brands_alias.'-'.$prod->prods_alias;
            $prod->prods_price = trim($prods_price);
            $prod->prods_amazon = trim($prods_amazon);      
            $prod->prods_foto = trim($prods_foto);
            $prod->prods_active = 1;
            $prod->currencies_id = $currency_default->currencies_id;      
            $prod->save();
            $this->message['prods']++;
            return $prod;
        }
    }

    private function toggleFilters($filters_name, $filters_value, $prod, $cats_id, $groups_id)
    {    
        $filters = Filters::whereRaw('LOWER(filters_name) = '."'".strtolower(trim($filters_name))."'")    
        ->with('cats_id')->get();
        $current = false;
        foreach ($filters as $filter)
        {
            foreach ($filter->cats_id as $cat) 
            {
                if ($cat->cats_id == $cats_id)
                {
                    $current = $filter;
                    break;
                } 
            }
        }
        if ($current)
        {      
            $current->prods()->detach([$prod->prods_id]);
            $current->prods()->attach([$prod->prods_id=>['filters_value'=>$filters_value]]);            
            return $current;
        }
        else
        {
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

    private function generate_alias_brands($name)
    {    
        $name = str_replace([' '], '-', $name);
        $exist = Brands::where('brands_alias', $name)->first();
        if ($exist)
        {
            $name .= rand(100, 999);            
        }
        return $name;
    }
    
    private function generate_alias_prods($name)
    {
        $name = str_replace([' '], '-', $name);
        $exist = Prods::where('prods_alias', $name)->first();
        if ($exist)
        {
            $name .= rand(100, 999);
        }
        return $name;
    }
    
    private function handle_string($string)
    {
        return preg_replace( '/[^[:print:]]/', '',$string);
    }

}
