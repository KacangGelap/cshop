<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\items;
use App\Models\category;
use App\Models\items_on_cart;
use App\Models\comment;
use Auth;
class itemController extends Controller
{
    public function index(){
        $items = items::all();
        return view('item.index')->withitems($items);
    }

    public function stall($id){
        $user = User::findOrFail($id);
        $current_items = items::where('user_id',$user->id)->get();
        return view('item.stall')->withuser($user)->with('current_items',$current_items);
    }   

    public function create_stall(){
        $category = category::all();
        return view('item.create')->with('category',$category);
    }
    
    public function store_stall(Request $request){
        // dd($request->file('foto1'));
        $request->validate([
           'item_name'=>'required|string|max:50',
           'item_price'=>'required|numeric|min:0',
           'item_description'=>'required|string',
           'item_count'=>'numeric|min:0',
           'foto1'=>'required|image|mimes:jpeg,png,jpg|max:3000',
           'foto2'=>'image|mimes:jpeg,png,jpg|max:3000',
        ]);
        try {
            $item = new items();
            $item->item_name = $request->input('item_name');
            $item->category_id = $request->input('category_id');
            $item->item_price = $request->input('item_price');
            $item->item_description = $request->input('item_description');
            $item->user_id = Auth::user()->id;
            $item->item_count = $request->input('item_count');
            //jika count > 0 atau tidak null, maka set tersedia
            // dd( $request->input('item_count') > 0);
            if ($request->input('item_count') > 0){
                $item->status = 'Tersedia';
            }else{
                $item->status = 'Habis';
            }
            //image1
            $item->foto1 = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto1')));
            //image2 jika ada
            if($request->hasFile('foto2')){
                $item->foto2 = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto2')));
            }
            $item->save();
        } catch (\Throwable $th) {
            return redirect('/stall/'.Auth::user()->id)->withstatus('kesalahan :'.$th);
        }
        return redirect('/stall/'.Auth::user()->id)->withstatus('Barang berhasil ditambah');
    }

    public function edit_stall($id, $item){
        $user = User::findOrFail($id);
        $category = category::all();
        $items = items::findOrFail($item);
        return view('item.edit')->with('user',$user)->with('items',$items)->with('category',$category);
    }

    public function update_stall(Request $request, $id, $item){
        // dd($request->file('foto1'));
        $request->validate([
           'item_name'=>'required|string|max:50',
           'item_price'=>'required|numeric|min:0',
           'item_description'=>'required|string',
           'item_count'=>'numeric|min:0',
           'foto1'=>'image|mimes:jpeg,png,jpg|max:3000',
           'foto2'=>'image|mimes:jpeg,png,jpg|max:3000',
        ]);
        try {
            $update = items::findOrFail($item);
            $update->update([
                'item_name' => $request->input('item_name'),
                'category_id' => $request->input('category_id'),
                'item_price' => $request->input('item_price'),
                'item_description' => $request->input('item_description'),
                'item_count' => $request->input('item_count'),
            ]);

            if ($request->input('item_count') > 0){
                $update->update([
                    'status' => 'Tersedia',
                ]);
            }else{
                $update->update([
                    'status' => 'Habis',
                ]);
            }

            if($request->hasFile('foto1')){
                $update->update([
                    'foto1' => 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto1'))),
                ]);
            }
            if($request->hasFile('foto2')){
                $update->update([
                    'foto2' => 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto2'))),
                ]);
            }
        } catch (\Throwable $th) {
            return redirect('/stall/'.Auth::user()->id)->withstatus('kesalahan :'.$th);
        }
        return redirect('/stall/'.Auth::user()->id)->withstatus('Barang berhasil diubah');
    }

    public function destroy(Request $request, $id, $item){
        try {
            $items = items::findOrFail($request->route('item'));
            // dd($items);
            $items->delete();
        } catch (\Throwable $th) {
            return redirect(url()->previous())->withgagal('galat saat menghapus item')->withth($th);
        }
        return redirect(url()->previous())->withsukses('item berhasil dihapus');
    }
    public function cart($id){
        $items = items::all();
        $user = User::findOrFail($id);
        $current_items = items_on_cart::where('user_id',$user->id)->get();
        return view('item.cart')->withuser($user)->with('current_items',$current_items)->with('items',$items);
    }
    public function addCart(Request $request, $item){
        $request->validate([
            'count' => 'required|numeric',
        ]);
        try {
            $current = items::findOrFail($item);

            $cart = new cart();
            $cart->user_id = Auth::user()->id;
            $cart->item_id = $current->id;
            $cart->item_count = $request->input('count');
            $cart->save();
        } catch (\Throwable $th) {
            return redirect('/')->withstatus('Terjadi Kesalahan');
        }
        return redirect('/cart/'.Auth::user()->id)->withstatus('Berhasil ditambah');
    }
    public function detail($item){
        $items = items::findOrFail($item);
        $comments = comment::where('item_id',$item)->get();
        return view('item.detail')->with('item',$items)->withcomments($comments);
    }
    public function checkout(Request $request, $item){

    }
    public function category($cat){
        $category = category::all();
        $item = items::where('category_id',$cat)->get();
        
        return view('item.category')->with('item',$item)->with('category',$category);
    }

}
