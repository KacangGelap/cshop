<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\userController;
use Illuminate\Support\Facades\Hash;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::middleware(['token'])->group(function () {

    Route::get('/user', function (Request $request){
        $user = User::all();
        return response()->json(['data'=>$user], 200, [], JSON_PRETTY_PRINT);
    });

    Route::post('/get/privilege/admin/create',function(Request $request) {
        $request->validate([
            'name' => 'required|string',
            'username' => 'required|string|unique:users',
            'email' => 'required|string|unique:users',
            'password' => 'required|string',
        ]);
        try {
            $user = new User();
            $user->name     = $request->input('name');
            $user->username = $request->input('username');
            $user->email    = $request->input('email');
            $user->password = Hash::make($request->input('password'));
            $user->save();
        } catch (\Throwable $th) {
            return response()->json(['message'=>'an error occured'], 500, [], JSON_PRETTY_PRINT);
        }

        return response()->json(['message'=>'User has been added'], 200, [], JSON_PRETTY_PRINT);
    });

    Route::delete('/get/privilege/admin/remove/{id}',function(Request $request, $id) {
        try {
            $user = User::findOrFail($id);
            $user->delete();
        } catch (\Throwable $th) {
            return response()->json(['message'=>'an error occured'], 500, [], JSON_PRETTY_PRINT);
        }
        return response()->json(['message'=>'User has been removed'], 200, [], JSON_PRETTY_PRINT);
    });
});

