<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    public $timestamps = false;
    protected $table = 'users';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */    
    protected $fillable = [
        'name', 'type', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role()
    {      
      return $this->belongsTo('App\UsersTypes', 'type_id', 'id');
    }

    public function cats(){      
      return $this->belongsToMany('App\Cats', 'cats_users', 'users_id', 'cats_id');
    }

    public function scopeAccessUsers($query){
      if (Auth::user()){
        $user = User::find(Auth::user()->id);
        if ($user->role->name == 'Super Admin'){
          return $query;
        }
        else{
          $query->where('users_id',0);
        }
      }
    }



}
