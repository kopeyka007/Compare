<?php

namespace App\Http\Controllers;
use App\Prods;
use App\Cats;
use App\Settings;
use App\Currencies;
use App\HistoryFilters;
use Illuminate\Http\Request;
use Storage;

use Aws\S3\Exception\S3Exception as S3;
class ProdsController extends Controller
{
    public function __construct()
    {
        
    }

    public function show()
    {       
        return view('panel.prods');
    }

    public function get_all()
    {
        $prods = Prods::with('filters_id.groups')->
        with('features_id')->
        with('brands_id')->
        with('cats_id')->
        whereHas('cats_id',function($q){
          $q->access();
        })->
        with('currencies_id')->
        get();
        SettingsController::set_config_s3();    
        $folder = Settings::select('s3_prods_folder')->first();    
        foreach ($prods as $prod) 
        {
            $prod->short_foto = $prod->prods_foto;
            $prod->prods_foto = empty($prod->prods_foto)?asset('images/nofoto.png'):Storage::disk('s3')->url($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);      
            $filters = array();
            $groups = array();
            foreach ($prod->filters_id as $filter)
            {
                $filters[$filter->filters_id] = $filter->pivot->filters_value;        
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_name'] = $filter->filters_name;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_type'] = $filter->filters_type;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_value'] = $filter->pivot->filters_value;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_units'] = $filter->filters_units;
                $groups[$filter->groups->groups_id]['groups_name'] = $filter->groups->groups_name;
                unset($filter->groups);
            }
            $prod['filters'] = $filters;
            $prod['groups'] = $groups;    
            unset($prod->filters_id);
            $features = array();      
            foreach ($prod->features_id as $feature) 
            {
                $features[$feature->features_id] = $feature->pivot->features_value;
            }
            $prod['features'] = $features;
            unset($prod->features_id);
        }
        $response['data'] = $prods;
        return $response; 
    }

    public function view($id)
    {
        $prod = Prods::find($id);    
        if ($prod)
        {
            $response['data'] = $prod;            
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
        }
        
        return $response;
    }
  
    public function save(Request $request)
    {    
        $prod = new Prods;
        $prods_id = $request->input('prods_id');
        //update
        if ( ! empty($prods_id))
        {
            $prod = Prods::find($prods_id);
        }
        if ( ! empty($prod))
        {
            $prod->cats_id = $request->input('cats_id')['cats_id'];
            $prod->brands_id = $request->input('brands_id')['brands_id'];        
            $prod->prods_name = $request->input('prods_name');        
            $prod->prods_alias = $request->input('prods_alias');        
            $prod->prods_full_alias = $request->input('brands_id')['brands_alias'].'-'.$request->input('prods_alias');
            $prod->prods_amazon = $request->input('prods_amazon');
            $prod->prods_price = ($request->input('prods_price') == 'null')?null:$request->input('prods_price');        
            $prod->prods_active = ($request->input('prods_active') == 'true')?1:0;
            $prod->currencies_id = $request->input('currencies_id')['currencies_id'];        
            if ($request->file){
                try {
                    $prod->prods_foto = $this->upload_s3($request->file, $prod);
                } catch(S3 $e) {                           
                    $response['data'] = false;          
                    $response['message'] = ['type'=>'danger', 'text'=>$e->getMessage()];                     
                    return $response;
                }
            }
            else{            
                if (empty($request->input('prods_foto'))){
                    SettingsController::set_config_s3();
                    $folder = Settings::select('s3_prods_folder')->first();
                    Storage::disk('s3')->delete($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);
                    $prod->prods_foto = '';
                }
                else{
                  $prod->prods_foto = $request->input('short_foto');  
                }
            }
            $filters = $request->input('filters');
            $features = $request->input('features');
            if ($prod->save()){          
              $this->set_relation_filters($prod->prods_id, $filters);
              $this->set_relation_features($prod->prods_id, $features);
              $response['data'] = true;          
              $response['message'] = ['type'=>'success', 'text'=>'Product saved'];
            }
        }
        return $response;
  }

    public function delete($id)
    {
        $prod = Prods::find($id);    
        if ($prod && $prod->delete())
        {
            //delete image
            if (!empty($prod->prods_foto))
            {
                SettingsController::set_config_s3();
                $folder = Settings::select('s3_prods_folder')->first();
                Storage::disk('s3')->delete($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);
            }
            //delete relations       
            $prod->filters_id()->detach();
            $prod->features_id()->detach();
            $response['data']['type'] = true;      
            $response['message'] = ['type'=>'success', 'text'=>'Product deleted'];      
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Product not found'];
        }
        return $response;
    }
    
    //relations with filters
    private function set_relation_filters($prods_id, $filters)
    {
        if (count($filters))
        {
            $prod = Prods::find($prods_id);
            foreach ($filters as $item=>$value)
            {
                $arr[$item]['filters_value'] = $value;
            }
            $prod->filters_id()->sync($arr);    
        }
    }
    
    //relations with features
    private  function set_relation_features($prods_id, $features)
    {
        if (count($features))
        {
            $prod = Prods::find($prods_id);
            foreach ($features as $item=>$value) 
            {
                $arr[$item]['features_value'] = $value;
            }
            $prod->features_id()->sync($arr);      
        }
    }
  
    private function upload_s3($file, $current = false)
    {
        SettingsController::set_config_s3();
        $s3 = Storage::disk('s3');    
        $prods_folder = Settings::select(['s3_prods_folder'])->find(1);
        if (!empty($current->prods_foto))
        {
            if ($s3->exists($prods_folder->s3_prods_folder.(empty($prods_folder->s3_prods_folder)?'':'/').$current->prods_foto))
            {          
                $s3->delete($prods_folder->s3_prods_folder.(empty($prods_folder->s3_prods_folder)?'':'/').$current->prods_foto);
            }  
        }    
        $filename = rand(100000, 999999).'_'.time().'.'.$file->getClientOriginalExtension();    
        $filepath = $prods_folder->s3_prods_folder.'/'.$filename;
        $s3->put('/'.$filepath, file_get_contents($file), 'public');            
        return $filename;
    }

  //Front
    private function get_prods_with_filters_group($ids)
    {    
        $prods = Prods::with('brands_id', 'filters_id', 'features_id')->where('prods_active',1)->find($ids);
        SettingsController::set_config_s3();
        $folder = Settings::select('s3_prods_folder')->first();  
        foreach ($prods as $prod) 
        {      
            $prod->prods_foto = empty($prod->prods_foto)?asset('images/nofoto.png'):Storage::disk('s3')->url($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);      
            $filters = array();
            $features = array();
            foreach ($prod->filters_id as $filter) 
            {
                $filters[$filter->filters_id]['filters_name'] = $filter->filters_name;
                $filters[$filter->filters_id]['filters_value'] = $filter->pivot->filters_value;
                $filters[$filter->filters_id]['filters_units'] = $filter->filters_units;
            }
            foreach ($prod->features_id as $feature) 
            {
                $feature->features_icon = !empty($feature->features_icon)?Storage::disk('s3')->url('features/'.$feature->features_icon):'';
                $features[$feature->features_id] = $feature;
                $features[$feature->features_id]['features_value'] = $feature->pivot->features_value;
                unset($feature->pivot);
            }
            $prod['filters'] = $filters;      
            $prod['features'] = $features;      
            unset($prod->filters_id);
            unset($prod->features_id);
        }
        return $prods;
  }

    public function get_compare_prods(Request $request)
    {    
        $url_or = $request->input('url');
        $url = str_replace('compare/', '', $url_or);
        $aliases = explode('-vs-', $url);        
        for ($i=0; $i < count($aliases) ; $i++) {
          $alias = str_replace('/', '', $aliases[$i]);
          $prod = Prods::where('prods_full_alias', $alias)->first();
          if ($prod){
            $ids[] = $prod->prods_id;
            $cats_id = $prod->cats_id;
          }
        }
        if (isset($ids) && count($ids))
        {      
            $response['data']['prods'] = $this->get_prods_with_filters_group($ids);
            $cat = Cats::select(['cats_photo'])->find($cats_id);
            $cat->cats_photo = empty($cat->cats_photo)?asset('images/nofoto.png'):Storage::disk('s3')->url('cats/'.$cat->cats_photo);      
            $currency = Currencies::where('currencies_default',1)->first();
            $response['data']['cats'] = $cat;
            $response['data']['currencies_default'] = $currency;
            //write history
            $history = new HistoryController;
            $history->set_history($ids, $url_or);
        }
        else
        {
            $response['data'] = false;      
        }
        return $response;
  }

    public function get_prods_detail(Request $request){
    $url = $request->input('url');
    $aliases = explode('/', $url);    
    //$category_alias = $aliases[2];
    $prods_full_alias  = $aliases[2];
    $prod = Prods::with('brands_id', 'cats_id', 'filters_id.groups', 'features_id')
    ->where('prods_full_alias', $prods_full_alias)    
    ->first();
    if ($prod)
    {
        SettingsController::set_config_s3();
        $folder = Settings::select('s3_prods_folder')->first();
        $prod->prods_foto = empty($prod->prods_foto)?asset('images/nofoto.png'):Storage::disk('s3')->url($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);      
        $groups = array();
        foreach ($prod->filters_id as $filter) 
        {
            if (! empty($filter->pivot->filters_value))
            {
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_name'] = $filter->filters_name;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_type'] = $filter->filters_type;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_value'] = $filter->pivot->filters_value;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_units'] = $filter->filters_units;
                $groups[$filter->groups->groups_id]['groups_name'] = $filter->groups->groups_name;        
            }
            unset($filter->groups);
        }
        $prod['groups'] = $groups;    
        unset($prod->filters_id);
        $features = array();
        foreach ($prod->features_id as $feature) 
        {
          $feature->features_icon = !empty($feature->features_icon)?Storage::disk('s3')->url('features/'.$feature->features_icon):'';
          $value = $feature->pivot->features_value;
          $feature['features_value'] = $value;
          if (!empty($value))
          {   
                if (!empty($feature->features_rate))
                {
                    if ($value >= $feature->features_norm)
                    {
                        $features['valid'][] = $feature;
                    }
                    else
                    {
                        $features['notvalid'][] = $feature;        
                    }
                }
                else
                {
                    if ($value < $feature->features_norm)
                    {
                        $features['valid'][] = $feature;
                    }
                    else
                    {
                        $features['notvalid'][] = $feature;        
                    }
                }
            }
        }
        $prod['features'] = $features;
        unset($prod->features_id);
        //get liked prods    
        $liked = Prods::where('cats_id', $prod->cats_id)
        ->where('prods_active',1)
        ->where('prods_id','<>',$prod->prods_id)
        ->with('brands_id')    
        ->take(7)
        ->get();
        foreach ($liked as $item)
        {
            $item->prods_foto = empty($item->prods_foto)?asset('images/nofoto.png'):Storage::disk('s3')->url($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$item->prods_foto);      
        }
        $prod['liked'] = $liked;
        $response['data'] = $prod;
    }
    else
    {
        $response['data'] = false;      
    }
    return $response;
  }
  
    public function get_history_filters($prods_id)
    {
        $history = HistoryFilters::selectRaw('filters_id, COUNT(filters_id) as filters_count')
                ->groupBy('filters_id')
                ->with('filters.groups')->where('prods_id', $prods_id)->get();
        $arr = array();                
        foreach ($history as $item)
        {
            $arr[$item->filters->groups->groups_id]['groups_filters'][$item->filters->filters_id]['filters_name'] = $item->filters->filters_name;
            $arr[$item->filters->groups->groups_id]['groups_filters'][$item->filters->filters_id]['filters_count'] = $item->filters_count;
            $arr[$item->filters->groups->groups_id]['groups_name'] = $item->filters->groups->groups_name;            
        }
        return $arr;
    }
  


}
