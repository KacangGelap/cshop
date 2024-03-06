<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\MOdels\billing;
class paymentController extends Controller
{
    public function wallet($id){
        $user = User::findOrFail($id);
        $data = billing::all();
        return view('payment.index')->withuser($user)->withdata($data);
    }
    public function billing(){
        return view('payment.billing');
    }
    public function checkout($id){
        return view('payment.checkout');
    }
    public function confirm_checkout(Request $request, $id){

    }
}
