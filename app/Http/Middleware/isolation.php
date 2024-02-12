<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class isolation
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (Null != $request->route('id')) {
            
            if(Auth::user()->id == $request->route('id') || Auth::user()->role == 'admin'){
                return $next($request);
            }else{
                return redirect('home')->withstatus('Access Denied');
            } 
        }
        else{
            return $next($request);
        }
        
    }
}
