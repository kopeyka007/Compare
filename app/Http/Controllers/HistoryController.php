<?php

namespace App\Http\Controllers;
use App\Prods;
use App\HistorySingle;
use App\HistoryPairs;
use App\HistoryAmazon;
use App\HistoryCompare;

use Illuminate\Http\Request;

class HistoryController extends Controller
{
  public function __construct()
  {    
  }

  public function set_history($ids){
    if (count($ids) > 1){
      //$this->set_single_history($ids);
      $this->set_pairs_history($ids);
      //$this->set_compare_history($ids[0]);
    }
  }

  public function set_history_amazon(Request $request){

  }
  
  private function set_single_history($ids){
    foreach ($ids as $prods_id) {
      $single = new HistorySingle;
      $single->prods_id = $prods_id;
      $single->save();
    }

  }

  private function set_pairs_history($ids){    
    for ($i=0; $i < count($ids); $i++)
      for ($j=0; $j < count($ids); $j++) { 
        if ($ids[$i] <> $ids[$j] && $i < $j)
          echo $ids[$i].$ids[$j].",";          
      }      
      
  }

  private function set_compare_history($id){
    $cats_id = Prods::select('cats_id')->where('prods_id',$id)->first();
    $history = new HistoryCompare;
    $history->cats_id = $cats_id->cats_id;
    $history->compare_link = 'temp_link';
    $history->save();
  }
  


}
