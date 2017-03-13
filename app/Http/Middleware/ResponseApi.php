<?php

namespace App\Http\Middleware;
use Closure;
use Validator;
use Illuminate\Support\Facades\Response;

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
    public function handle($request, Closure $next, $controller)
    {
        //var_dump($request->controller);
        //exit();
        /*$data = $next($request);
        return Response::json(array(
                'success' => false,
                'errors' => Validator::getData(),

            ), 200); // 400 being the HTTP code for an invalid request.
        */
        //$model = app($fullyQualifiedNameOfModel);
          $validator = app('validator')->make($request->input(), $model->rules($request));
          if ($validator->fails()) {
             return $this->response($request, $validator->errors());
            }
          return $next($request);
    }
}
