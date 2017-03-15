<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProdsFeatures extends Model
{
    public $timestamps = false;
    protected $table = 'prods_features';
    protected $primaryKey ='rows_id';            
}
