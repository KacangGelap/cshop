<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Auth;
class user
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()->role == 'user' || Auth::user()->role == 'admin' && $request->route('id') == Auth::user()->id){
            return $next($request);
        }
        else{
            return redirect('/')->withstatus('Access Denied');
        }
    }
}
