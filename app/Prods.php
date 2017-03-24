<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;
class Prods extends Model
{
    public $timestamps = false;
    protected $table = 'prods';
    protected $primaryKey ='prods_id';

    protected $appends = array('prods_price_cur');
    
    public function getProdsPriceCurAttribute()
    {
        $currency = Currencies::find($this->currencies_id);
        if ($currency){
          return $currency->attributes['currencies_symbol'].' '.$this->prods_price;
        }
        else{
          return null;
        } 
    }
    /*
    public function getProdsFotoAttribute()
    {
        if (empty($this->attributes['prods_foto'])){
          $cat = Cats::find($this->attributes['cats_id']);
          if (!empty($cat->attributes['cats_photo'])){
            return $cat->attributes['cats_photo'];          
          }
          else{
            return asset('images/nofoto.png');
          }
        }
        else
        {
          return $this->attributes['prods_foto'];
        }
    }    
    */
    public function filters_id(){      
      return $this->belongsToMany('App\Filters', 'prods_filters', 'prods_id', 'filters_id')->withPivot('filters_value', 'filters_comment');
    }
    public function features_id(){      
      return $this->belongsToMany('App\Features', 'prods_features', 'prods_id', 'features_id')->withPivot('features_value');  
    }
    public function brands_id(){
      return $this->belongsTo('App\Brands','brands_id');
    }
    public function cats_id(){
      return $this->belongsTo('App\Cats','cats_id');
    }    
    public function currencies_id(){
      return $this->belongsTo('App\Currencies','currencies_id')->select(['currencies_id','currencies_symbol']);
    }
}
