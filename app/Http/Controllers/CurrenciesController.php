<?php

namespace App\Http\Controllers;
use App\Currencies;
use Illuminate\Http\Request;
class CurrenciesController extends Controller
{
    public function __construct()
    {    
    }

    public function show()
    {       
        return view('panel.currencies');
    }

    public function get_all()
    {
        $currencies = Currencies::all();    
        $response['data'] = $currencies;
        return $response;    
    }

    public function get_show_list()
    {
        $currencies = Currencies::accessCurrencies()->get();    
        $response['data'] = $currencies;
        return $response;    
    }
  
    public function save(Request $request)
    {             
        $currency = new Currencies;
        $currencies_id = $request->input('currencies_id');
        //update
        if ( ! empty($currencies_id))
        {
            $currency = Currencies::find($currencies_id);
        }
        if ( ! empty($currency) )
        {
            $currency->currencies_name = $request->input('currencies_name');        
            $currency->currencies_symbol = $request->input('currencies_symbol');        
            $currency->currencies_default = $this->set_default($request->input('currencies_default'), $currency->currencies_id);
            if ($currency->save())
            {
                $response['data'] = true;          
                $response['message'] = ['type'=>'success', 'text'=>'Currency saved'];
            }
        }          
        return $response;
    }

    public function delete($id)
    {
        $currency = Currencies::find($id);
        if ($currency)
        {      
            if ($currency->currencies_default == 0)
            {
                $currency->delete();
                $response['data']['type'] = true;      
                $response['message'] = ['type'=>'success', 'text'=>'Currency deleted'];      
            }
            else
            {
                $response['data'] = false;          
                $response['message'] = ['type'=>'danger', 'text'=>'Can not delete default currency'];
            }
        }
        else
        {
            $response['data'] = false;          
            $response['message'] = ['type'=>'danger', 'text'=>'Currency not found'];
        }
        return $response;
    }

    private function set_default($value, $id=0)
    {
        $default = Currencies::where('currencies_default',1)->first();
        if (!empty($value))
        {
            if ($default)
            {
                $default->currencies_default = 0;
                $default->save();        
            }
            return true;
        }
        else
        {
            if ($default && $default->currencies_id <> $id)
            {        
                return false;
            } 
            else 
            {
                return true;
            }
        }
    }
}
