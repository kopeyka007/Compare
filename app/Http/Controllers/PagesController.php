<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

class PagesController extends Controller
{
    public function test($list){
        return "f.test";
        //var_dump($list);
    }
    public function list(){
      return 'test';
    }
}
