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
    Route::middleware(['user','admin'])->group(function () {
        Route::get('/user/{id}/wallet',[App\Http\Controllers\paymentController::class,'index'])->name('Buy Wallet');
    });

    //Item Management
        //Admin
    Route::middleware(['admin'])->group(function(){
        Route::get('/item',[App\Http\Controllers\itemController::class,'index'])->name('Managemen Barang');
    }
    );
        //User
    Route::middleware(['user'])->group(function () {
        Route::get('stall/{id}',[App\Http\Controllers\itemController::class,'stall'])->name('Kios Anda');
    });
});