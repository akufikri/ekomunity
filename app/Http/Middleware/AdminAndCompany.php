<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminAndCompany
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if(Auth::user()->id_level == "1" || Auth::user()->id_level == "7" || Auth::user()->id_level == "5" || Auth::user()->id_level == "6" || Auth::user()->id_level == "2" || Auth::user()->id_level == "4"){
            return $next($request);
        }

        return redirect('/');
    }
}
