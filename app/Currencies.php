<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Currencies extends Model
{
    public $timestamps = false;
    protected $table = 'currencies';
    protected $primaryKey ='currencies_id';

    public function scopeAccessCurrencies($query){
      if (Auth::user()){
        $user = User::find(Auth::user()->id);
        if ($user->role->name == 'Super Admin'){
          return $query;
        }
        else{
          $query->where('currencies_id',0);
        }
      }
    }
}
