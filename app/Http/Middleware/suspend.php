<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class suspend
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // dd(Auth::user()->suspension);
        if(Auth::user()){
            if (Auth::user()->suspension == 'True') {
                return redirect('/banned');
            } else {
                return $next($request);    
            }
        }
        else{
            return $next($request);
        }
        
        
    }
}
