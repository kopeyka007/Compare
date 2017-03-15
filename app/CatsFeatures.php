<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CatsFeatures extends Model
{
    public $timestamps = false;
    protected $table = 'cats_features';
    protected $primaryKey ='rows_id';    

}
