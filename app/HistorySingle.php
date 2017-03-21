<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistorySingle extends Model
{
    public $timestamps = false;
    protected $table = 'history_single';
    protected $primaryKey ='rows_id';
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function prods(){
      return $this->belongsTo('App\Prods','prods_id');
    }
}
