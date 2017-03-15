<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    public $timestamps = false;
    protected $table = 'features';
    protected $primaryKey ='features_id';

    public function cats_id(){      
      return $this->belongsToMany('App\Cats', 'cats_features', 'features_id', 'cats_id');
    }
}
