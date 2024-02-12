<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Hash, Route, Auth;
class userController extends Controller
{
    public function index() 
    {
        $user = User::all();
        return view('user.index')->with('user',$user);
    }
    public function search(Request $request) 
    {
        $request->validate([
            'query'=>'string'
        ]);
        try {
            $user = User::where('username', 'like', $request->input('query') . '%')
            ->orWhere('username', 'like', '%' . $request->input('query'))
            ->orWhere('name', 'like', '%' . $request->input('query'))
            ->orWhere('Name', 'like', $request->input('query') . '%')
            ->get();;
        } catch (\Throwable $th) {
            $users = User::all();
            return view('user.index')->with('user',$users);
        }
        return view('user.search')->with('user',$user)->withquery($request->input('query'));
    }
    public function profile($id) 
    {
        $user = User::findOrFail($id);
        return view('user.profile')->with('user',$user);
    }
    public function create(){
        return view('user.create');
    }
    public function store(Request $request){
        $request->validate([
            'name'=> 'required|string|max:255',
            'username'=> 'required|string|max:255|unique:users',
            'email'=> 'required|string|email|unique:users',
            'roles'=> 'required|string|max:255',
            'password'=>'required|string|confirmed'
        ]);
        try {
            $user = new User();
            // dd($user);
            $user->name     = $request->input('name');
            $user->username = strtolower($request->input('username'));
            $user->role     = $request->input('roles');
            $user->email    = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
            
        } catch (\Throwable $th) {
            return redirect('/user/create')->with('error',$th);
        }
        return redirect('/user')->withsukses('data berhasil ditambah');
    }
    public function edit($id){
        $user = User::findOrFail($id);
        return view('user.edit')->with('user',$user);
    }
    public function update(Request $request, $id){
        $request->validate([
            'name'=> 'string|max:255',
            'roles'=> 'string|max:255',
            'password'=>'string'
        ]);
        
        try {
            $user = User::findOrFail($id);
            if($user->name != $request->input('name')){
                $user->update([
                    'name'=>$request->input('name'),
                ]);
            }
            if($user->username != $request->input('username')){
                $request->validate([
                    'username'=> 'string|unique:users'
                ]);
                
                $user->update([
                    'username'=>strtolower($request->input('username')),
                ]);
            }
            if($user->role != $request->input('roles') && Auth::user()->role == 'admin'){
                
                $user->update([
                    'role'=>$request->input('roles'),
                ]);
            }
            if($user->email != $request->input('email')){
                $request->validate([
                    'email'=> 'string|email|unique:users'
                ]);
               
                $user->update([
                    'email'=>$request->input('email'),
                ]);
            } 
            if($user->password != $request->input('password')){
               
                $user->update([
                    'password'=>Hash::make($request->input('password')),
                ]);
            }
        } catch (\Throwable $th) {
            return redirect('/user/edit/'.$user->id);
        }
        if (Auth::user()->role == 'admin' && Auth::user()->id != $user->id) {
            #admin panel
            return redirect('/user/')->withsukses('data berhasil diubah');
        }else {
             #profile panel
        return redirect('/profile/'.$user->id)->withsukses('data berhasil diubah');
        }
       
    }

    public function pass($id)
    {
        $user = User::findOrFail($id);
        return view('user.pass')->with('user',$user);
    }

    public function passChange(Request $request, $id)
    {
        $request->validate([
            'current' => 'required|string',
            'new' => 'required|string|confirmed'
        ]);
        try {
            $user = User::findOrFail($id);
            
            if(Hash::check($request->input('current'),$user->password )){
                // dd($request->input('new'));    
                $user->update([
                    $user->password => Hash::make($request->input('new'))
                ]);
            }
                else{
                    // dd('boo');
                    return redirect('/user/passchange/'.$user->id)->withstatus('masukkan password dengan benar');
                }
            
        } catch (\Throwable $th) {
            return redirect()->back()->withstatus($th);
        }
        return redirect('/profile/'.$user->id)->withuser($user);
    }

    public function destroy(Request $request,$id)
    {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Throwable $th) {
            return redirect(url()->previous())->withgagal('galat saat menghapus pengguna');
        }
        return redirect(url()->previous())->withsukses('pengguna berhasil dihapus');
    }
}
