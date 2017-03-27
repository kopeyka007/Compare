<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Cats extends Model
{
    public $timestamps = false;
    protected $table = 'cats';
    protected $primaryKey ='cats_id';

    public function features(){      
      return $this->belongsToMany('App\Features', 'cats_features', 'cats_id', 'features_id');
    }

    public function filters(){      
      return $this->belongsToMany('App\Filters', 'cats_filters', 'cats_id', 'filters_id');
    }

    public function prods(){
      return $this->hasMany('App\Prods','cats_id');
    }

    public function brands(){
      return $this->hasMany('App\Brands','cats_id');
    }

    public function users(){      
      return $this->belongsToMany('App\User', 'cats_users', 'cats_id', 'users_id');
    }

    public function scopeAccess($query)
    {
      if (Auth::user()){
        $user = User::find(Auth::user()->id);
        switch ($user->role->name) {          
          case 'Super Admin':
            return $query;
            break;
          case 'Category Admin':
            return $query->with('users')->has('users');
            break;
          case 'Product Uploader':
            return $query->where('cats_id',0);            
            //return null;
            break;
        }
      }
    }
}
