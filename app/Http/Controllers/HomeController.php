<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\items;
// use App\Models\items_on_stall;
use App\Models\items_on_cart;
use Auth;
class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        //check item di kios dan di keranjang
        $item = items::all();
        $cart = items_on_cart::where('user_id',Auth::user()->id)->get();
        return view('home')->with('item',$item)->with('cart',$cart);
    }
}
