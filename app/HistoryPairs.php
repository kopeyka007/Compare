<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryPairs extends Model
{
    public $timestamps = false;
    protected $table = 'history_pairs';
    protected $primaryKey ='rows_id';
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
    
    public function prods1_id(){
      return $this->belongsTo('App\Prods','prods1_id');
    }

    public function prods2_id(){
      return $this->belongsTo('App\Prods','prods2_id');
    }
}
