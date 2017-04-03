<?php

namespace App\Http\Controllers;
use App\Cats;
use App\Prods;
use App\Filters;
use App\Settings;
use Illuminate\Http\Request;
use Storage;

class CatsController extends Controller
{
    public function __construct()
    {    
    }

    public function show()
    {       
        return view('panel.cats');
    }

    public function get_show_list()
    {
        $cats = Cats::with('features')->accessCats()->get();
        SettingsController::set_config_s3();
        foreach ($cats as $cat)
        {
            $cat->short_foto = $cat->cats_photo;
            $cat->cats_photo = empty($cat->cats_photo)?asset('images/nofoto.png'):Storage::disk('s3')->url('cats/'.$cat->cats_photo);
        }
        $response['data'] = $cats;
        return $response;    
  }

    public function get_access_list()
    {
        $cats = Cats::with('features')->access()->get();
        SettingsController::set_config_s3();
        foreach ($cats as $cat)
        {
            $cat->short_foto = $cat->cats_photo;
            $cat->cats_photo = empty($cat->cats_photo)?asset('images/nofoto.png'):Storage::disk('s3')->url('cats/'.$cat->cats_photo);      
        }
        $response['data'] = $cats;
        return $response;    
    }

    public function view($id)
    {
        $cat = Cats::with('features')->find($id);    
        if ($cat)
        {
            $response['data'] = $cat;            
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
        }
        
        return $response;
    }
  
    public function save(Request $request)
    {
        $response = ['data' => false, 'message' => ['type' => 'danger', 'text' => 'Cats saving error']];
        $cat = new Cats;
        $cat_id = $request->input('cats_id');
        if ( ! empty($cat_id))
        {
          $cat = Cats::find($cat_id);
        }

        if ( ! empty($cat))
        {
            if ($request->file)
            {
                try
                {
                    $cat->cats_photo = $this->upload_s3($request->file, $cat);
                }
                catch(S3 $e)
                {                           
                    $response['data'] = false;
                    $response['message'] = ['type' => 'danger', 'text' => $e->getMessage()]; 
                    return $response;
                }
            }
            else
            {            
                if (empty($request->input('cats_photo')))
                {
                    SettingsController::set_config_s3();
                    Storage::disk('s3')->delete('cats/'.$cat->cats_photo);
                    $cat->cats_photo = '';
                }
                else
                {
                    $cat->cats_photo = $request->input('short_foto');
                }
            }

            $cat->cats_name = $request->input('cats_name');
            $cat->cats_alias = $request->input('cats_alias');
            $cat->cats_default = $this->set_default($request->input('cats_default'), $cat->cats_id);
            if ($cat->save())
            {
                $response['data'] = true;
                $response['message'] = ['type'=>'success', 'text'=>'Category was successfully saved'];
            }
        }

        return $response;
    }

    public function delete($id)
    {
        $cat = Cats::find($id);    
        if ($cat)
        {
            if ($cat->cats_default == 0)
            {
                $cat->delete();
                //delete image
                if (!empty($cat->cats_photo))
                {
                    SettingsController::set_config_s3();
                    Storage::disk('s3')->delete('cats/'.$cat->cats_photo);
                }
                //delete relations       
                $cat->filters()->detach();
                $cat->features()->detach();
                $response['data'] = true;      
                $response['message'] = ['type'=>'success', 'text'=>'Category deleted'];      
            }
            else
            {
                $response['data'] = false;          
                $response['message'] = ['type'=>'danger', 'text'=>'Can not delete default category'];
            }
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
        }

        return $response;
    }

    public function get_filters($id)
    {
        $cat = Cats::with('filters', 'filters.groups')->find($id);
        if ($cat)
        {
            $groups = array();
            foreach ($cat->filters as $filter) 
            {        
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_name'] = $filter->filters_name;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_type'] = $filter->filters_type;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_value'] = $filter->pivot->filters_value;
                $groups[$filter->groups->groups_id]['groups_filters'][$filter->filters_id]['filters_units'] = $filter->filters_units;
                $groups[$filter->groups->groups_id]['groups_name'] = $filter->groups->groups_name;
                unset($filter->groups);
            }
            unset($cat->filters);
            $cat['groups'] = $groups;
            $response['data'] = $cat;
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
        }
        return $response;
  }

    public function get_filters_groups($id)
    {
        $cats = Cats::with('filters.groups')->find($id);
        $groups = array();
        foreach ($cats->filters as $filter) 
        {      
            $groups[$filter->groups->groups_name][] = $filter;
        }    
        return $groups;    
    }

    public function get_features($id)
    {
        $cat = Cats::find($id);
        if ($cat)
        {
            $response['data'] = $cat->features;
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
        }
        return $response; 
    }

    public function get_brands($id)
    {
        $cat = Cats::find($id);
        if ($cat)
        {
            $response['data'] = $cat->brands;
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Category not found'];
        }
        return $response;  
    }

    private function set_default($value, $id = 0)
    {
        $default = Cats::where('cats_default',1)->first();    
        if (!empty($value))
        {
            if ($default)
            {
                $default->cats_default = 0;
                $default->save();        
            }
            return true;
        }
        else
        {
            if ($default && $default->cats_id <> $id)
            {        
              return false;
            } 
            else 
            {
                return true;
            }
        }
    }
  
    private function upload_s3($file, $current = false)
    {
        SettingsController::set_config_s3();
        $s3 = Storage::disk('s3');        
        if (!empty($current->cats_photo))
        {
            if ($s3->exists($current->cats_photo))
            {          
                $s3->delete($current->cats_photo);
            }  
        }    
        $filename = rand(100000, 999999).'_'.time().'.'.$file->getClientOriginalExtension();    
        $filepath = 'cats/'.$filename;
        $s3->put('/'.$filepath, file_get_contents($file), 'public');    
        return $filename;
    }
  
    //Front ---------------------
    public function shortlist()
    {    
        $cats = Cats::with('prods')
        ->with(['prods'=>function($q){
            $q->where('prods_active',1);
        }, 'prods.brands_id', 'prods.filters_id'])    
        ->get();
        foreach ($cats as $cat) 
        {
            foreach ($cat->prods as $prod) 
            {
              $filters = array();
              foreach ($prod->filters_id as $filter) 
              {
                $filters[$filter->filters_id] = $filter->pivot->filters_value;
              }
              $prod['filters'] = $filters;
              unset($prod->filters_id);
            }      
        }
        return $cats;    
    }

    public function get_compare_filters(Request $request)
    {
        $url_or = $request->input('url');
        $url = str_replace('compare/', '', $url_or);
        $aliases = explode('-vs-', $url);    
        for ($i=0; $i < count($aliases) ; $i++) 
        {
            $alias = str_replace('/', '', $aliases[$i]);
            $prod = Prods::where('prods_full_alias', $alias)->first();
            if ($prod)
            {
                $ids[] = $prod->cats_id;
            }
        }    
        if (isset($ids) && count($ids))
        {
            $response['data'] = $this->get_all_cats_filters($ids);
        }
        else
        {
            $response['data'] = false;      
        }
        return $response;
    }

    private function get_all_cats_filters($ids)
    {
        $cats = Cats::with('filters.groups')->find($ids);        
        foreach ($cats as $cat) 
        {      
            foreach ($cat->filters as $filter) 
            {
                $groups[$filter->groups->groups_id]['groups_filters'][] = $filter;
                $groups[$filter->groups->groups_id]['groups_name'] = $filter->groups->groups_name;        
            }
        }
        return $groups;    
    }

    public function catslist(Request $request)
    {
        $url = $request->input('urlCat');
        $aliases = explode('/', $url);  
        $cats_alias = $aliases[1];
        $cats = Cats::with('prods')
          ->where('cats_alias', $cats_alias)
          ->with(['prods'=>function($q){
              $q->where('prods_active',1);
          },'prods.brands_id', 'prods.filters_id'])      
          ->first();
        if (empty($cats))
        {     
            $cats = Cats::with('prods')
            ->where('cats_default', 1)
            ->with(['prods'=>function($q){
                $q->where('prods_active',1);
            },'prods.brands_id', 'prods.filters_id'])      
            ->first();
        }
        if ($cats)
        {
            SettingsController::set_config_s3();
            $folder = Settings::select('s3_prods_folder')->first();
            foreach ($cats->prods as $prod) 
            {
                $prod->prods_foto = empty($prod->prods_foto)?asset('images/nofoto.png'):Storage::disk('s3')->url($folder->s3_prods_folder.(empty($folder->s3_prods_folder)?'':'/').$prod->prods_foto);      
                $filters = array();
                foreach ($prod->filters_id as $filter) 
                {
                    $filters[$filter->filters_id] = $filter->pivot->filters_value;
                }
                $prod['filters'] = $filters;
                unset($prod->filters_id);
            }
            $cats_id = $cats->cats_id;
            $filters = Filters::where('filters_filter',1)
            ->with(['cats_id'=>function ($query) use($cats_id){
              $query->whereRaw('cats.cats_id = '.$cats_id);
            }])
            ->with(['prods'=>function($query) use($cats_id){
              $query->whereRaw('prods.cats_id = '. $cats_id);        
            }])
            ->get();
            $filters_cats = array();
            foreach ($filters as $filter) 
            {        
                if (count($filter->cats_id)){
                  $filters_values = array();
                  foreach ($filter->prods as $prod) {
                     $filters_values[] = $prod->pivot->filters_value;
                  }
                  unset($filter->cats_id);
                  unset($filter->prods);
                  $filter['filters_values'] = array_unique($filters_values);
                  $filters_cats[] = $filter;          
                } 
            }
            $response['data']['cats'] = $cats;
            $response['data']['filters'] = $filters_cats;
        }
        else
        {
            $response['data'] = false;
        }
        return $response;
    }
}