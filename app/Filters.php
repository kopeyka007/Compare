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
}
