<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cats extends Model
{
    public $timestamps = false;
    protected $table = 'cats';
    protected $primaryKey ='cats_id';

    public function features(){      
      return $this->belongsToMany('App\Features', 'cats_features', 'cats_id', 'features_id');
    }

    public function filters(){      
      return $this->belongsToMany('App\Filters', 'cats_filters', 'cats_id', 'filters_id');
    }

    public function prods(){
      return $this->hasMany('App\Prods','cats_id');
    }

    public function brands(){
      return $this->hasMany('App\Brands','cats_id');
    }
}
