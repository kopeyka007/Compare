<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cats extends Model
{
    public $timestamps = false;
    protected $table = 'cats';
    protected $primaryKey ='cats_id';

    public function test(){
      return $this->morphMany('App\Features', 'cats_features');
    }
}
