<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\items;
use App\Models\category;
use App\Models\items_on_cart;
use App\Models\comment;
use App\Models\shipped_item;
use App\Models\track;
use Auth;
class itemController extends Controller
{
    public function index(){
        $items = items::all();
        return view('item.index')->withitems($items);
    }
    public function search(Request $request) 
    {
        $request->validate([
            'query'=>'string'
        ]);
        try {
            $items = items::where('item_name', 'like', $request->input('query') . '%')
            ->orWhere('item_name', 'like', '%' . $request->input('query'))
            ->orWhere('item_description', 'like', '%' . $request->input('query'))
            ->orWhere('item_description', 'like', $request->input('query') . '%')
            ->get();;
        } catch (\Throwable $th) {
            $items = items::all();
            return view('item.index')->with('items',$items);
        }
        return view('item.search')->with('items',$items)->withquery($request->input('query'));
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
        $count = $pending_items->filter(function ($item) {
            return $item->status === 'menunggu penjual' || $item->status === 'diproses penjual'|| $item->status === 'dikomplain';
        })->count();        
        // dd($count)
        // dd($pending_items);
        return view('item.stall')->withuser($user)->with('current_items',$current_items)->with('counts',$count);
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


    //sebagai pembeli


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
        $ship = shipped_item::where('user_id',Auth::user()->id)->orderBy('status')->get();
        // dd($ship->track->last());
        return view('item.ship')->with('ship',$ship);
    }
    public function track_shipment($id, $item){
        $track = track::where('shipped_item_id',$item)->get();
        // dd($track->last()->ship->item->item_name);
        return view('item.track')->with('track', $track);
    }
    public function shipment_remove($id, $item){
        $ship = shipped_item::findOrFail($item);
        // dd($ship);
        if ($ship->status == 'menunggu penjual' || $ship->status == 'diproses penjual' || $ship->status == 'menunggu kurir' ) {
            // dd($ship);
            $ship->item->update([
                'item_count'=>$ship->item->item_count + $ship->item_count,
            ]);
            $ship->update([
                'status'=>'transaksi gagal'
            ]);
            
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'transaksi dibatalkan oleh pembeli';
            $track->save();
    
            Auth::user()->update([
                'ewallet'=> Auth::user()->ewallet + $ship->total_price
            ]);
            return redirect('shipment/'.Auth::user()->id)->withsukses('pesanan berhasil dibatalkan');
        }
        else{
            return redirect('shipment/'.Auth::user()->id)->withgagal('gagal membatalkan pesanan');
        }
        
    }
    public function shipment_complete($id, $item){
        $ship = shipped_item::findOrFail($item);
        // dd($ship->item->user);
        $ship->update([
            'status'=>'diterima pembeli'
        ]);
        $ship->item->user->update([
            'ewallet'=> $ship->item->user->ewallet + $ship->total_price
        ]);
        $track = new track();
        $track->shipped_item_id = $ship->id;
        $track->status = 'telah diterima oleh yang bersangkutan';
        $track->save();
        return redirect('shipment/'.Auth::user()->id)->withsukses('pesanan diterima! mohon beri penilaian pada barang');
    }
    public function review($id, $item){

    }
    public function rate($id, $item){

    }
    public function shipment_complain($id, $item){
        $data = shipped_item::findOrFail($item);
        // dd($data);
        return view('item.complain')->with('data',$data);
    }
    public function request_complain(Request $request, $id, $item){
        $request->validate([
            'description' => 'required|string|min:10',
            'foto' => 'required|image|mimes:jpg,jpeg,png'
        ]);
        try {
            $data = shipped_item::findOrFail($item);
            // dd($data);
            
            $track = new track();
            $track->shipped_item_id = $data->id;
            $track->status = 'pembeli mengajukan pengembalian barang, menunggu penjual untuk konfirmasi';
            $track->img = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto')));
            $track->save();

            $data->update([
                'status'=>'dikomplain',
            ]);
            return redirect('/shipment/'.Auth::id())->withsukses('berhasil mengajukan pengembalian');
        } catch (\Throwable $th) {
            return redirect('/shipment/'.Auth::id())->withgagal('galat saat mengunggah data');
        }
    }
    
    // sebagai penjual

    public function pending($id){
        $current_items = items::where('user_id', Auth::user()->id)->get();
        // dd(Auth::user()->item->get()->ship->count());
        //kodingan baru, perlu diingat
        $pending_items = collect();
        foreach ($current_items as $item) {
            $pending = shipped_item::where('item_id', $item->id)->orderBy('status')->get();
            // dd($pending);
            $pending_items = $pending_items->merge($pending)->sortByDesc('status');
        }

        return view('item.pending')->with('pending_items',$pending_items);

    }
    public function shipment_accept($buyer, $item){
        try {
            $ship = shipped_item::findOrFail($item);
            $ship->update([
                'status'=>'diproses penjual'
            ]);
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'barang sedang dikemas oleh penjual';
            $track->save();
        } 
        catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
        return redirect()->back()->with('sukses','status telah diubah');
    }
    public function shipment_ready($buyer, $item){
        try {
            $ship = shipped_item::findOrFail($item);
            $ship->update([
                'status'=>'menunggu kurir'
            ]);
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'barang telah dikemas, menunggu kurir';
            $track->save();
        } 
        catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
        return redirect()->back()->with('sukses','status telah diubah');
    }
    public function shipment_return($buyer, $item){
        try {
            $ship = shipped_item::findOrFail($item);
            $ship->update([
                'status'=>'dikirim balik'
            ]);
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'ajuan pengembalian diterima, menunggu kurir';
            $track->save();
        } 
        catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
        return redirect()->back()->with('sukses','status telah diubah');
    }
    public function reject_return($buyer, $item){
        try {
            $ship = shipped_item::findOrFail($item);
            $ship->update([
                'status'=>'pesanan diterima'
            ]);
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'ajuan pengembalian ditolak oleh pembeli';
            $track->save();
        } 
        catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
        return redirect()->back()->with('sukses','status telah diubah');
    }
}
