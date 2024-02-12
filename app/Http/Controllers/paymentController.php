<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\MOdels\billing;
class paymentController extends Controller
{
    public function index($id){
        $user = User::findOrFail($id);
        $data = billing::all();
        return view('payment.index')->withuser($user)->withdata($data);
    }
    public function detail(){
        return view('payment.detail');
    }
}
