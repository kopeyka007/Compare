<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HistoryAmazon extends Model
{
    public $timestamps = false;
    protected $table = 'history_amazon';
    protected $primaryKey ='rows_id';
    
    public static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->created_at = $model->freshTimestamp();
        });
    }
}
