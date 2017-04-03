<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryFilters extends Model
{
    public $timestamps = false;
    protected $table = 'history_filters';
    protected $primaryKey ='rows_id';
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
    public function filters(){
      return $this->belongsTo('App\Filters','filters_id');
    }
    
}
