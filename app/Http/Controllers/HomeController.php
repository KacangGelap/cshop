<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\items;
use App\Models\shipped_item;
use App\Models\category;
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
        $ship = shipped_item::all();
        $cart = items_on_cart::where('user_id',Auth::user()->id)->get();
        $category = category::all();
        return view('home')->with('item',$item)->with('cart',$cart)->with('category',$category)->with('ship',$ship);
    }
}
