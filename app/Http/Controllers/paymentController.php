<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\billing;
use App\Models\payment;
use App\Models\items_on_cart;
use App\Models\shipped_item;
use Auth, Hash;
class paymentController extends Controller
{
    public function wallet($id){
        $user = User::findOrFail($id);
        $data = billing::all();
        return view('payment.index')->withuser($user)->withdata($data);
    }
    public function billing($bil){
        $data = billing::findOrFail($bil);
        // dd($data);
        return view('payment.billing')->with('data',$data);
    }
    public function payment(Request $request, $bil){
        $request->validate([
            'password' => 'required|string'
        ]);
    try {
        // dd(Auth::user()->id);
        $user = User::findOrFail(Auth::user()->id);
        
        $billing = billing::findOrFail($bil);
        
        if (Hash::check($request->input('password'), $user->password)) {
            
            $user->update([
                'ewallet' => Auth::user()->ewallet + $billing->amount
            ]);
            
            $payment = new payment();
            $payment->user_id = Auth::user()->id;
            $payment->billing_id = $billing->id;
            $payment->save();
        }
        else{
            return redirect('/billing/'.$billing->id)->withstatus('Password salah !');
        }
       
    } catch (\Throwable $th) {
        return redirect('/')->withstatus($th);
    }
    return redirect('/')->withsukses('CubeCoins berhasil ditambah');
    }
    public function checkout($id,$cart){
        $item = items_on_cart::find($cart);
        return view('payment.checkout')->with('item',$item);
    }
    public function confirm_checkout(Request $request, $id, $cart){
        $request->validate([
            'total'=>'required|numeric',
            'password'=>'required|string'
        ]);
        try {
            if(Hash::check($request->input('password'), Auth::user()->password)){
                $item = items_on_cart::findOrFail($cart);
                $pay = Auth::user()->ewallet - $request->input('total');
                $stock = itetms::findOrFail($item->id);
                // dd($pay);
                if($pay >= 0){
                    $ship = new shipped_item();
                    $ship->user_id = Auth::user()->id;
                    $ship->item_id = $item->item_id;
                    $ship->item_count = $item->item_count;
                    $ship->total_price = $request->input('total');
                    $ship->status = 'menunggu penjual';
                    $ship->payment_status = 'True';
                    $ship->save();
    
                    Auth::user()->update([
                        'ewallet' => $pay
                    ]);
                    $stock->update([
                        'item_count' => $stock->item_count - $item->item_count
                    ]);
                    $item->delete();
                    
                    return redirect('home')->withsukses('Pesanan telah dibuat');    
                }else{
                    return redirect('home')->withstatus('CubeCoin Tidak Cukup !');    
                }
                
            }else{
                return redirect('home')->withstatus('Password salah');
            }
            

        } catch (\Throwable $th) {
            return redirect('home')->withstatus('Terjadi Kesalahan');
        }
    }

}
