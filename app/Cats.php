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
}
