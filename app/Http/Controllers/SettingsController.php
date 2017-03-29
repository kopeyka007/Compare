<?php

namespace App\Http\Controllers;
use App\Settings;
use Illuminate\Http\Request;
use Config;

class SettingsController extends Controller
{
  public function __construct()
  {
    
  }

  public function show(){       
    return view('panel.settings');
  }

  public function get_all(){    
    $settings = Settings::access()->find(1);
    $response['data'] = $settings;
    return $response;
  }
  
  public function save(Request $request){    
    $current = Settings::find(1);
    if ($current){
      $current->s3_key = $request->input('s3_key');        
      $current->s3_secret = $request->input('s3_secret');                   
      $current->s3_region = $request->input('s3_region');      
      $current->s3_bucket = $request->input('s3_bucket');
      $current->s3_prods_folder = $request->input('s3_prods_folder');
      if ($current->save()){
        $response['data'] = true;          
        $response['message'] = ['type'=>'success', 'text'=>'Settings saved'];
      }
    }
    return $response;
  }
  
  public static function set_config_s3(){
    $current = Settings::find(1);    
    Config::set('filesystems.disks.s3.key', $current->s3_key);
    Config::set('filesystems.disks.s3.secret', $current->s3_secret);
    Config::set('filesystems.disks.s3.region', $current->s3_region);
    Config::set('filesystems.disks.s3.bucket', $current->s3_bucket);
  }
  
}
