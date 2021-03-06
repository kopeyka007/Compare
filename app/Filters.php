<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Filters extends Model
{
    public $timestamps = false;
    protected $table = 'filters';
    protected $primaryKey ='filters_id';

    public function groups_id()
    {      
      return $this->belongsTo('App\Groups', 'groups_id', 'groups_id');
    }
    public function cats_id(){      
      return $this->belongsToMany('App\Cats', 'cats_filters', 'filters_id', 'cats_id');
    }
    public function groups()
    {      
      return $this->hasOne('App\Groups', 'groups_id', 'groups_id');
    }
    public function prods(){
      return $this->belongsToMany('App\Prods', 'prods_filters', 'filters_id', 'prods_id')->withPivot('filters_value', 'filters_comment');
    }
}
