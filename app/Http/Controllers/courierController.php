<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\shipped_item;
use App\Models\track;
use App\Models\selected_shipment;
use Auth;
class courierController extends Controller
{
    public function accept($item)
    {
        
        try {
            if (Auth::user()->role == 'courier') {
                $current = shipped_item::findOrFail($item);

                $selected = new selected_shipment();
                $selected->user_id = Auth::user()->id;
                $selected->shipment_id = $current->id;
                
                $track = new track();
                $track->shipped_item_id = $current->id;
                $track->status = 'Dikonfirmasi Oleh kurir ' . '[' .Auth::user()->name. ']';
                $selected->save();
                $track->save();
                $current->update([
                    'status' => 'sedang dikirim'
                ]);
                return redirect()->back()->with('sukses','Data Berhasil Dikonfirmasi');
            } else {
                return redirect()->back()->with('gagal','Access Denied !');
            }
        } catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
    }

    public function selected($id)
    {
        $data = selected_shipment::where('user_id',$id)->get();
        // dd($data->first()->ship->user->name);
        return view('item.confirmed')->with('data',$data);
    }
    public function change($item)
    {
        $data = selected_shipment::findOrFail($item);
        $status = $data->ship->status;
        // dd($status);
        if ($status == 'diterima pembeli'|| $status == 'dikomplain' || $status == 'transaksi gagal') {
            return redirect('courier/'.Auth::id())->with('status','access denied');
        } else {
            return view('item.change')->with('data',$data)->with('status',$status);
        }
        
        
    }
    public function update(Request $request, $item)
    {
        $request->validate([
        'status'=>'required|string',
        'description'=>'required|string',
        'foto'=>'image|mimes:jpg,jpeg,png|max:2048',
        ]);
    
        $shipment_status = selected_shipment::findOrFail($item)->ship;
        $shipment_status->update([
            'status'=>$request->input('status'),
        ]);
        if($request->input('status')== 'diterima pembeli'){
            $shipment_status->item->user->update([
                'ewallet'=> $shipment_status->total_price + $shipment_status->item->user->ewallet]);
        }
        $track = new track();
        $track->shipped_item_id = selected_shipment::findOrFail($item)->ship->id;
        $track->status = $request->input('description'); 
        if(NULL != $request->file('foto')){
            $track->img = 'data:image/jpg;charset:utf8;base64,'.base64_encode(file_get_contents($request->file('foto')));
        }
        $track->save();
        return redirect('courier/'.Auth::id())->with('sukses','Data berhasil diubah');
    }
    public function fail(Request $request, $item){
        try {
            $ship = shipped_item::findOrFail($item);
            $ship->update([
                'status'=>'transaksi gagal'
            ]);
            $track = new track();
            $track->shipped_item_id = $ship->id;
            $track->status = 'barang berhasil dikembalikan, mohon maaf atas ketidaknymanan nya';
            $track->save();
        } 
        catch (\Throwable $th) {
            return redirect()->back()->with('gagal','terjadi kesalahan');
        }
        return redirect()->back()->with('sukses','status telah diubah');
    }
}
