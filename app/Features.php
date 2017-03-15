<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Features extends Model
{
    public $timestamps = false;
    protected $table = 'features';
    protected $primaryKey ='features_id';        
}
