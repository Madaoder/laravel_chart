<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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

Route::get('/', [HomeController::class, 'home']);
Route::get('/computer', [HomeController::class, 'computer']);
Route::get('/mouse', [HomeController::class, 'mouse']);
Route::get('/keyboard', [HomeController::class, 'keyboard']);

Route::get('/cart', [CartController::class, 'showCart']);
Route::get('/cart/buy', [CartController::class, 'buyItem'])->middleware('auth');
Route::post('/cart/callback', [CartController::class, 'callback']);
Route::get('/cart/{id}', [CartController::class, 'addItem']);
Route::post('/cart/{id}', [CartController::class, 'changeQty']);
Route::delete('/cart/{id}', [CartController::class, 'deleteItem']);

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('home');
})->name('dashboard');
