<?php

namespace App\Http\Middleware;
use Closure;
use Validator;
//use Illuminate\Support\Facades\Response;
use Symfony\Component\HttpFoundation\Response;


class ResponseApi
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $guard
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $app = app();
        $data = $next($request);        
        $currentAction = \Route::currentRouteAction();
        list($controller_name, $method) = explode('@', $currentAction);
        $controller_name = preg_replace('/.*\\\/', '', $controller_name);        
        //$controller = $app->make($controller_name);
        $response = $data->original;
        $response['message'] = ['type'=>'danger', 'text'=>'Test-api'];        
        return response()->json($response); 
        

          /*$model = app("App/User");
          $validator = app('validator')->make($request->input(), $model->rules($request));
          if ($validator->fails()) {
             return $this->response($request, $validator->errors());
            }
          return $next($request);*/
        //var_dump($next($request));
        //return $next($request);

    }
}
