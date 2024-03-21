<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use App\Models\items;
use Auth;
class buyer
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //mengisolasi jika seller iseng membeli item miliknya sendiri
        //jika itemnya miliknya sendiri, redirect ke home
        
        if (Null != $request->route('item')) {
            $item = items::findOrFail($request->route('item'));
            // dd($item->user->id != Auth::user()->id);
            return Auth::user()->id != $item->user->id ? $next($request) : redirect('home')->withstatus('Tidak bisa membeli barang anda sendiri') ;
        }
        else{
            return $next($request);
        }
    }
}
