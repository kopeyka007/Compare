<?php

namespace App\Http\Controllers;
use App\Prods;
use App\Cats;
use App\HistorySingle;
use App\HistoryPairs;
use App\HistoryAmazon;
use App\HistoryCompare;

use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Carbon;

class HistoryController extends Controller
{
  public function __construct()
  {    
  }

  public function set_history($ids, $url){
    if (count($ids) > 1){
      $this->set_single_history($ids);
      $this->set_pairs_history($ids);
      $this->set_compare_history($ids[0], $url);
    }
  }

  public function set_history_amazon(Request $request){
    $prods_amazon = empty($request->input('prods_amazon'))?'':$request->input('prods_amazon');
    $prods_id = $request->input('prods_id');    
    $history['prods_id'] = $prods_id;    
    $history['prods_amazon'] = $prods_amazon;    
    HistoryAmazon::insert($history);
  }

  private function set_single_history($ids){
    $history = array();
    foreach ($ids as $prods_id) {
      $history[] = ['prods_id' => $prods_id];      
    }
    HistorySingle::insert($history);
  }

  private function set_pairs_history($ids){    
    $history = array();
    for ($i=0; $i < count($ids); $i++)
      for ($j=0; $j < count($ids); $j++) { 
        if ($ids[$i] <> $ids[$j] && $i < $j){          
          $history[] = ['prods1_id'=>$ids[$i], 'prods2_id'=>$ids[$j]];
        }
    }    
    HistoryPairs::insert($history);
  }

  private function set_compare_history($id, $url){    
    $cats_id = Prods::select('cats_id')->where('prods_id',$id)->first();
    $history['cats_id'] = $cats_id->cats_id;
    $history['compare_link'] = url($url);
    HistoryCompare::insert($history);
  }

  // Get history
  public function get_history(){
    $data['data']['amazon_top10'] = $this->get_history_amazon_top10();
    $data['data']['amazon_last10days'] = $this->get_history_amazon_last10days();
    $data['data']['single_compare_top10'] = $this->get_single_compare_top10();
    $data['data']['pair_compare_top10'] = $this->get_pair_compare_top10();
    $data['data']['count_all_compare_last10days'] = $this->count_all_compare_last10days();
    $data['data']['count_all_compare_last10days_days'] = $this->count_all_compare_last10days_days();
    $data['data']['count_all_compare_cats_top10'] = $this->count_all_compare_cats_top10();        
    return $data;
  }
  
  public function get_history_amazon_top10(){    
    $result = HistoryAmazon::selectRaw('count(prods_id) as prods_count, prods_id')
    ->groupBy('prods_id')
    ->with('prods', 'prods.brands_id', 'prods.cats_id')
    ->whereHas('prods.cats_id',function($q){
      $q->access();
    })
    ->orderBy('prods_count', 'DECS')
    ->take(10)
    ->get();
    return $result;
  }

  public function get_history_amazon_last10days(){    
    //10 days ego
    $time10days =  time() - (10 * 24 * 60 * 60);    
    $result = HistoryAmazon::with('prods', 'prods.brands_id', 'prods.cats_id')
    ->whereHas('prods.cats_id',function($q){
      $q->access();
    })
    ->where('created_at', '>', $time10days)    
    ->orderBy('created_at', 'DECS')    
    ->get();
    $arr = array();
    foreach ($result as $item) {
      $key = date('d-m-Y', strtotime($item->created_at)); 
      if (!isset($arr[$key])){
        $arr[$key] = 0;
      } 
      $arr[$key]++;       
    }
    return $arr;
  }

  public function get_single_compare_top10(){
    $result = HistorySingle::selectRaw('count(prods_id) as prods_count, prods_id')
    ->groupBy('prods_id')    
    ->with('prods', 'prods.brands_id', 'prods.cats_id')    
    ->whereHas('prods.cats_id',function($q){
      $q->access();
    })
    ->orderBy('prods_count', 'DECS')
    ->take(10)
    ->get();
    return $result;
  }

  public function count_all_compare_cats_top10(){
    $result = Cats::withCount('prods')
    ->orderBy('prods_count', 'DECS')
    ->access()      
    ->get();  
    $k=0;  
    foreach ($result as $cat){
      if ($cat->prods_count > 0){
        $arr[$k]['cats_count'] = $cat->prods_count;
        $arr[$k]['cats_id'] = $cat;
        $k++;
      }
    }    
    return $arr;
  }

  public function get_pair_compare_top10(){
    $result  = HistoryPairs::selectRaw('count(prods1_id) as prods1_count, prods1_id, count(prods2_id) as prods2_count, prods2_id')
    ->groupBy('prods1_id','prods2_id')
    ->with('prods1_id.brands_id', 'prods2_id.brands_id', 'prods1_id.cats_id', 'prods2_id.cats_id')
    ->whereHas('prods1_id.cats_id',function($q){
      $q->access();
    })
    ->orderBy('prods1_count', 'DECS')
    ->take(10)
    ->get();
    return $result;
  }

  public function count_all_compare_last10days(){
    //10 days ego
    $time10days =  time() - (10 * 24 * 60 * 60);    
    $result = HistoryCompare::where('created_at', '>', $time10days)        
    ->orderBy('created_at', 'DECS')    
    ->get();
    $arr = array();
    foreach ($result as $item) {
      $key = date('N', strtotime($item->created_at)); 
      if (!isset($arr[$key])){
        $arr[$key] = 0;
      } 
      $arr[$key]++;
    }
    return $arr;
  }

  public function count_all_compare_last10days_days(){
    //10 days ego
    $time10days =  time() - (10 * 24 * 60 * 60);    
    $result = HistoryCompare::where('created_at', '>', $time10days)        
    ->orderBy('created_at', 'DECS')    
    ->get();
    $arr = array();
    foreach ($result as $item) {
      $key = date('d-m-Y', strtotime($item->created_at)); 
      if (!isset($arr[$key])){
        $arr[$key] = 0;
      } 
      $arr[$key]++;
    }
    return $arr;
  }

}
