<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Auth;

class Admin
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
        if(Auth::user() != null){
            if(Auth::user()->id_level == "1" || Auth::user()->id_level == "5" || Auth::user()->id_level == "6"){
                return $next($request);
            }
        }
        

        return redirect('/');
        
    }
}
