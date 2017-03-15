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
        //var_dump($request->controller);
        //exit();
        $data = $next($request);
        return response()->json($data); // 400 being the HTTP code for an invalid request.
        
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
