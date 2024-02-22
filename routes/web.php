<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    if (Auth::user()) {
        return view('home');
    } else {
        return view('welcome');
    }
    
    
})->name('welcome');

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/me',function(){
    return view('misc.me');
})->name('who made this');

Route::get('/about-us',function(){
    return view('misc.aboutus');
})->name('about us');

Route::middleware(['auth','checking'])->group(function () {
    //User Management
        //Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/user', [App\Http\Controllers\userController::class, 'index'])->name('User Management');
        Route::any('/user/search/', [App\Http\Controllers\userController::class, 'search'])->name('User Result');
        Route::get('/user/create', [App\Http\Controllers\userController::class, 'create'])->name('Create User');
        Route::post('/user/create', [App\Http\Controllers\userController::class, 'store']);
    });
        //Universal
    Route::get('/profile/{id}',[App\Http\Controllers\userController::class,'profile'])->name('Profile');
    Route::get('/user/passchange/{id}',[App\Http\Controllers\userController::class,'pass'])->name('Change Password');
    Route::put('/user/passchange/{id}',[App\Http\Controllers\userController::class,'passChange']);
    Route::get('/user/edit/{id}', [App\Http\Controllers\userController::class, 'edit'])->name('Edit User');
    Route::put('/user/edit/{id}', [App\Http\Controllers\userController::class, 'update']);
    Route::delete('/user/delete/{id}', [App\Http\Controllers\userController::class, 'destroy']);
    
        //wallet payment
    Route::get('/user/{id}/wallet',[App\Http\Controllers\paymentController::class,'wallet'])->name('Buy Wallet');
    Route::get('/user/{id}/wallet/{wallet}',[App\Http\Coontrollers\paymentController::class,'billing'])->name('Buy Cubecoins');

    //Item Management
        //Admin
    Route::middleware(['admin'])->group(function(){
        Route::get('/item',[App\Http\Controllers\itemController::class,'index'])->name('Managemen Barang');
    }
    );
        //User
            //Kios
    Route::get('stall/{id}',[App\Http\Controllers\itemController::class,'stall'])->name('Kios Anda');
    Route::get('stall/{id}/create',[App\Http\Controllers\itemController::class,'create_stall'])->name('Tambah Barang ke Kios');
    Route::post('stall/{id}/create',[App\Http\Controllers\itemController::class,'store_stall']);
    Route::get('stall/{id}/edit/{item}',[App\Http\Controllers\itemController::class,'edit_stall'])->name('Edit Barang Anda');
    Route::put('stall/{id}/edit/{item}',[App\Http\Controllers\itemController::class,'update_stall']);
    Route::delete('stall/{id}/item/delete/{item}',[App\Http\Controllers\itemController::class,'destroy']);
    
            //Keranjang & Checkout
    Route::get('/cart/{id}',[App\Http\Controllers\itemController::class,'cart'])->name('Keranjang Anda');
    Route::get('/checkout/{id}/{item}',[App\Http\Controllers\paymentontroller::class,'checkout'])->name('checkout Barang');
    Route::post('/checkout/{id}/{item}',[App\Http\Controllers\paymentController::class,'confirm_checkout']);
});