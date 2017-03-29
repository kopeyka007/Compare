<?php

namespace App;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Settings extends Model
{
    public $timestamps = false;
    protected $table = 'settings';
    protected $primaryKey ='id';
    
    public function scopeAccess($query)
    {
        
      if (Auth::user()){
        $user = User::find(Auth::user()->id);        
        switch ($user->role->name) {          
          case 'Super Admin':
            return $query;
            break;
          case 'Category Admin':
            return $query->where('id',0);
            break;
          case 'Product Uploader':
            return $query->where('id',0);
            break;
        }
      }
      else{
        return $query->where('id',0);
      }
    }
    
    
}
