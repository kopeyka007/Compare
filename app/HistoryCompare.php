<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryCompare extends Model
{
    public $timestamps = false;
    protected $table = 'history_compare';
    protected $primaryKey ='rows_id';
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }

    public function cats_id(){
      return $this->belongsTo('App\Cats','cats_id');
    }
}
