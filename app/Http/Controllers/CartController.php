<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart()
    {
        $order = Order::where('user_id', Auth::user()->id)->with('items')->first();
        return view('cart.show', compact('order'));
    }
}
