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
        switch ($user->role->name) {
            case 'Super Admin':
                return $query;
            break;
            case 'Category Admin':
                return $query->where('author_id', $user->id);
            break;
            case 'Product Uploader':
                return $query->where('id', 0);
            break;
        }
      }
    }



}
