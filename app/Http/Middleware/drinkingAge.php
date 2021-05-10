<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class drinkingAge
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {   

        if($request->age < 18){
            return response()->view('welcome');
        }else{
        return $next($request);
        }
    }
}
