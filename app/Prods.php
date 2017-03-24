<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prods extends Model
{
    public $timestamps = false;
    protected $table = 'prods';
    protected $primaryKey ='prods_id';

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
}
