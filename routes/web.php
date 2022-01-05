<?php

use App\Http\Controllers\CartController;
use Illuminate\Support\Facades\Route;
use App\Models\Item;

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
    return view('home', ['items' => $items]);
});

Route::get('/cart', [CartController::class, 'showCart']);
Route::get('/cart/buy', [CartController::class, 'buyItem'])->middleware('auth');
Route::post('/cart/callback', [CartController::class, 'callback']);
Route::get('/cart/{id}', [CartController::class, 'addItem']);
Route::post('/cart/{id}', [CartController::class, 'changeQty']);
Route::delete('/cart/{id}', [CartController::class, 'deleteItem']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');
