<?php
namespace App\Http\Controllers;

use App\User;
use App\UsersTypes;
use App\Http\Controllers\Controller;
use Auth;
use App\Http\Requests;
use Illuminate\Http\Request;

//use Guzzle\Http\Client;

class UsersController extends Controller
{
    public function __construct()
    {
    }
    
    public function show()
    {       
        return view('panel.users');
    }

    public function get_show_list()
    {
        $users = User::with('role')
        ->with('cats')
        ->accessUsers()
        ->get();
        $i=0;
        $response = array();
        foreach ($users as $user)
        {
            $cats = array();
            foreach ($user->cats as $cat)
            {
                $cats[$cat->cats_id] = true;
            }
            $response['data'][$i]['id'] = $user->id;      
            $response['data'][$i]['email'] = $user->email;
            $response['data'][$i]['type'] = ['id'=>$user->role->id, 'name'=>$user->role->name];
            $response['data'][$i]['cats'] = $cats;      
            $i++;
        }
        return $response;
    }

    public function get_users_types()
    {
        $response['data'] = UsersTypes::all();
        return $response;
    }

    public function view($id)
    {
        $user = User::find($id);    
        if ($user)
        {
            $response['data'] = $user;
            $response['data']['type'] = ['id'=>$user->role->id, 'name'=>$user->role->name];      
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
        }
        return $response;
    }

    public function save(Request $request)
    {
        $user = new User;
        $user_id = $request->input('id');        
        if ( ! empty($user_id))
        {
            $user = User::find($user_id);
        }
        if ( ! empty($user))
        {
            $user->email = $request->input('email');
            $user->type_id = $request->input('type')['id'];
            $user->password = ($request->input('password') == '')?$user->password:bcrypt($request->input('password'));
            $cats = $request->input('cats');            
            if ($user->save())
            {
                $this->set_relation_cats($user->id, $cats);
                $response['data'] = true;          
                $response['message'] = ['type'=>'success', 'text'=>'User saved'];
            }
        }   
        return $response;
  }

    public function delete($id)
    {
        $user = User::find($id);        
        if ($user && $user->delete())
        {
            $user->cats()->detach();
            $response['data']['type'] = true;      
            $response['message'] = ['type'=>'success', 'text'=>'User deleted'];      
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'User not found'];
        }
        return $response;
  }

    private function set_relation_cats($user_id, $cats)
    {    
        if (count($cats))
        {
            $cats = array_filter($cats, function ($value){
                return !empty($value);
                });
            $cats = array_keys($cats);            
            $user = User::find($user_id);
            $user->cats()->sync($cats);    
        }
    }
}
?>

