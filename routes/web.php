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
Route::get('/cart/{id}', [CartController::class, 'addItem'])->middleware('auth');
Route::post('/cart/{id}', [CartController::class, 'changeQty'])->middleware('auth');
Route::delete('/cart/{id}', [CartController::class, 'deleteItem'])->middleware('auth');

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');
