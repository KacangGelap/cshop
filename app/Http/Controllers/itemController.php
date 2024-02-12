<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\items;
use App\Models\items_on_stall;
use App\Models\items_on_cart;
use Auth;
class itemController extends Controller
{
    public function index(){
        $items = items_on_stall::all();
        return view('item.index')->withitems($items);
    }
    public function stall($id){
        $user = User::findOrFail($id);
        $current_items = items_on_stall::where('user_id',$user->id)->get();
        return view('item.stall')->withuser($user)->with('current_items',$current_items);
    }   
    public function cart($id){
        $user = User::findOrFail($id);
        $current_items = items_on_cart::where('user_id',$user->id)->get();
        return view('item.cart')->withuser($user)->with('current_items',$current_items);
    }
    public function add_stall(Request $request, $id){
        $request->validate([
           ''=>'required',
           ''=>'required',
           ''=>'required',
           ''=>'required',
           ''=>'required',
           ''=>'required',
        ]);
        try {
            //code...
        } catch (\Throwable $th) {
            //throw $th;
        }
    }
}
