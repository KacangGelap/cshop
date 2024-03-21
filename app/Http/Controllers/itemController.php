<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\items;
use App\Models\category;
use App\Models\items_on_cart;
use App\Models\comment;
use App\Models\shipped_item;
use Auth;
class itemController extends Controller
{
    public function index(){
        $items = items::all();
        return view('item.index')->withitems($items);
    }

    public function stall($id){
        $user = User::findOrFail($id);
        $current_items = items::where('user_id', $user->id)->get();
        //kodingan baru : perlu diingat
        //panggil collect untuk membuat wadah collection kosong
        $pending_items = collect();
        //panggil setiap id milik barang user lalu store ke collection kosong
        foreach ($current_items as $item) {
            $pending = shipped_item::where('item_id', $item->id)->get();
            $pending_items = $pending_items->merge($pending);
        }
        // dd($pending_items);
        return view('item.stall')->withuser($user)->with('current_items',$current_items)->with('pending_items',$pending_items);
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
        $current = items::findOrFail($item);
        $old = items_on_cart::where('item_id', $current->id)
                    ->where('user_id', Auth::user()->id)
                    ->first();
        // dd($old);
        $request->validate([
            'item_count' => 'required|numeric|min:1|max:'.$current->item_count,
        ]);
        try {
            // add existing item to cart by updating the values
            if(NULL != $old){
                $new_count = $old->item_count +  $request->input('item_count');
                // check if it's not exceed the items stock
                if($new_count <= $current->item_count){
                    $old->update([
                        'item_count'=> $new_count
                    ]);
                }else{
                    // dd('hello');
                    return redirect('/item/'.$current->id)->withgagal('jumlah barang tidak bisa melebihi stok');
                }
                
            }else{
                $cart = new items_on_cart();
                $cart->user_id = Auth::user()->id;
                $cart->item_id = $current->id;
                $cart->item_count = $request->input('item_count');
                $cart->save();
            }
            
        } catch (\Throwable $th) {
            return redirect('/')->withgagal('Galat saat menambahkan item, item mungkin sudah ada di keranjang');
        }
        return redirect('/item/'.$current->id)->withsukses('Berhasil ditambah');
    }

    public function cart_delete(Request $request, $cart){
        $user = Auth::user();
        $cart = items_on_cart::findOrFail($cart);
        $cart->delete();
        return redirect('cart/'.$user->id)->withsukses('Berhasil Dihapus');
    }

    public function detail($item){
        $items = items::findOrFail($item);
        $comments = comment::where('item_id',$item)->first();
        
        return view('item.detail')->with('item',$items)->withcomments($comments);
    }
   
    public function category($cat){
        $category = category::all();
        $item = items::where('category_id',$cat)->get();
        
        return view('item.category')->with('item',$item)->with('category',$category);
    }

    public function shipment($id){
        $ship = shipped_item::where('user_id',Auth::user()->id)->get();
        return view('item.ship')->with('ship',$ship);
    }
    public function pending($id){
        $current_items = items::where('user_id', Auth::user()->id)->get();
        $pending_items = collect();
        foreach ($current_items as $item) {
            $pending = shipped_item::where('item_id', $item->id)->get();
            $pending_items = $pending_items->merge($pending);
        }
        return view('item.pending')->with('pending_items',$pending_items);
        
    }
    public function accept_shipment(Request $request, $id){
        $ship = shipped_item::where('user_id',Auth::user()->id)->get();
        return view('item.ship')->with('ship',$ship);
    }
}
