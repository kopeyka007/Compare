<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Prods extends Model
{
    public $timestamps = false;
    protected $table = 'prods';
    protected $primaryKey ='prods_id';            
}
