<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\billing;
use App\Models\payment;
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
                'ewallet' => $billing->amount
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
    return redirect('/')->withttatus('CubeCoins berhasil ditambah');
    }
    public function checkout($id){
        return view('payment.checkout');
    }
    public function confirm_checkout(Request $request, $id){

    }
}
