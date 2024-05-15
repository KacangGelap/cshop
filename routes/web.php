<?php

use Illuminate\Support\Facades\Route;
// use Illuminate\Support\Facades\App; NOTE : KODINGAN HARAMMMMMM
// use App\Http\Controllers\HomeController;
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
        // dd('hello');
        $item = App\Models\items::all();
        $ship = App\Models\shipped_item::all();
        $pending = $ship->where('status','menunggu kurir');
        $cart = App\Models\items_on_cart::where('user_id',Auth::user()->id)->get();
        $category = App\Models\category::all();
        return view('home')->with('item',$item)->with('cart',$cart)->with('category',$category)->with('ship',$ship)->with('pending',$pending);
    } else {
        return view('welcome');
    }
    
    
})->middleware(ban::class)->name('welcome');

Auth::routes();


Route::get('/me',function(){
    return view('misc.me');
})->name('who made this');

Route::get('/about-us',function(){
    return view('misc.aboutus');
})->name('about us');
Route::get('/banned',function(){
    if(Auth::user()->suspension == 'True'){
        return view('misc.banned');
    }
    else{
        return redirect('home');
    }
})->name('banned');
Route::middleware(['auth','checking','ban'])->group(function () {
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    //User Management
        //Admin
    Route::middleware(['admin'])->group(function () {
        Route::get('/user', [App\Http\Controllers\userController::class, 'index'])->name('User Management');
        Route::any('/user/search/', [App\Http\Controllers\userController::class, 'search'])->name('User Result');
        Route::get('/user/create', [App\Http\Controllers\userController::class, 'create'])->name('Create User');
        Route::post('/user/create', [App\Http\Controllers\userController::class, 'store']);
        Route::post('/user/suspend/{id}', [App\Http\Controllers\userController::class, 'suspend']);
        Route::post('/user/appeal/{id}', [App\Http\Controllers\userController::class, 'appeal']);
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
    Route::get('/billing/{bil}',[App\Http\Controllers\paymentController::class,'billing'])->name('Buy Cubecoins');
    Route::post('/billing/{bil}',[App\Http\Controllers\paymentController::class,'payment']);
    //Item Management
        //Admin
    Route::middleware(['admin'])->group(function(){
        Route::get('/item',[App\Http\Controllers\itemController::class,'index'])->name('Managemen Produk');
        Route::any('/item/search/', [App\Http\Controllers\itemController::class, 'search'])->name('Cari Produk');
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
            //Detail item
    Route::get('/item/{item}',[App\Http\Controllers\itemController::class,'detail'])->name('Detail Item');
            //Keranjang & Checkout
    Route::get('/cart/{id}',[App\Http\Controllers\itemController::class,'cart'])->name('Keranjang Anda');
    Route::middleware(['buyer'])->group(function(){
        
        Route::post('/add/{item}',[App\Http\Controllers\itemController::class,'addCart']);
        Route::delete('/delete/{cart}',[App\Http\Controllers\itemController::class,'cart_delete']);
        Route::get('/checkout/{id}/{cart}',[App\Http\Controllers\paymentController::class,'checkout'])->name('checkout Barang');
        Route::post('/checkout/{id}/{cart}',[App\Http\Controllers\paymentController::class,'confirm_checkout']);
        
    });
            //Categories
    Route::get('category/{cat}',[App\Http\Controllers\itemcontroller::class,'category'])->name('Kategori');
            //Shipment & change status
    Route::get('shipment/{id}',[App\Http\Controllers\itemcontroller::class,'shipment'])->name('Pesanan kamu');
    Route::get('shipment/{id}/track/{item}',[App\Http\Controllers\itemcontroller::class,'track_shipment'])->name('Lacak Status Pesanan');
    Route::put('shipment/{buyer}/accept/{item}',[App\Http\Controllers\itemcontroller::class,'shipment_accept']);
    Route::put('shipment/{buyer}/ready/{item}',[App\Http\Controllers\itemcontroller::class,'shipment_ready']);
    Route::put('shipment/{buyer}/return/{item}',[App\Http\Controllers\itemcontroller::class,'shipment_return']);
    Route::put('shipment/{buyer}/reject/{item}',[App\Http\Controllers\itemcontroller::class,'reject_return']);
    Route::put('shipment/{id}/delete/{item}',[App\Http\Controllers\itemcontroller::class,'shipment_remove']);
    Route::put('shipment/{id}/done/{item}',[App\Http\Controllers\itemcontroller::class,'shipment_complete']);
    Route::get('shipment/{id}/rate/{item}',[App\Http\Controllers\itemcontroller::class,'review']);
    Route::post('shipment/{id}/rate/{item}',[App\Http\Controllers\itemcontroller::class,'rate']);
    Route::get('shipment/{id}/complain/{item}',[App\Http\Controllers\itemController::class,'shipment_complain'])->name('Ajukan Pengembalian Barang');
    Route::post('shipment/{id}/complain/{item}',[App\Http\Controllers\itemController::class,'request_complain']);
    
    Route::get('pending/{id}',[App\Http\Controllers\itemcontroller::class,'pending'])->name('Menunggu Konfirmasi');
    Route::post('pending/{id}',[App\Http\Controllers\itemcontroller::class,'accept_shipment'])->name('Menunggu Konfirmasi');
        //courier
    Route::put('courier/accept/{item}',[App\Http\Controllers\courierController::class,'accept']);
    Route::get('courier/{id}',[App\Http\Controllers\courierController::class,'selected'])->name('Kelola orderan kamu');
    Route::get('courier/change/{item}',[App\Http\Controllers\courierController::class,'change'])->name('Edit Status Orderan');
    Route::put('courier/change/{item}',[App\Http\Controllers\courierController::class,'update']);
    Route::put('courier/fail/{item}',[App\Http\Controllers\courierController::class,'fail']);
});