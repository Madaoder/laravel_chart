<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Models\Item;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    $items = Item::all();
    return view('home', compact('items'));
});

Route::get('/cart', [CartController::class, 'showCart'])->middleware('auth');

Route::get('/add/chart/{id}', function ($id) {
    $orderCheck = Order::where('user_id', Auth::user()->id)->first();
    //Wether user have order or not
    if (!$orderCheck) {
        Order::create(['user_id' => Auth::user()->id]);
    }
    $itemCheck = $orderCheck->items()->where('item_id', $id)->first();
    //Wether user have add this item to the chart or not
    if (!$itemCheck) {
        $item = Item::find($id);
        $orderCheck->items()->attach($item->id, ['qty' => 1]);
    }
    return Redirect()->back();
})->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');
