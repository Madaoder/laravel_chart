<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function showCart(Request $request)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        return view('cart.show', ['items' => $cart, 'total' => $total]);
    }

    public function addItem(Request $request, $id)
    {
        $item = Item::find($id);
        $newCart = [
            'id' => $item->id,
            'name' => $item->name,
            'price' => $item->price,
            'qty' => 1,
        ];
        $cart = $request->session()->has('cart') ? $request->session()->get('cart') : [];
        if (array_key_exists($id, $cart)) {
            $cart[$id]['qty']++;
        } else {
            $cart[$id] = $newCart;
        }
        $total = $request->session()->has('total') ? $request->session()->get('total') : 0;
        $total += $item->price;
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->back();
    }

    public function changeQty(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $qty = $request->qty;
        $oldQty = $cart[$id]['qty'];
        $diff = $qty - $oldQty;
        $cart[$id]['qty'] = $qty;
        $total += $diff * $cart[$id]['price'];
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }

    public function deleteItem(Request $request, $id)
    {
        $cart = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $total -= $cart[$id]['qty'] * $cart[$id]['price'];
        unset($cart[$id]);
        $request->session()->put('cart', $cart);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }

    public function buyItem(Request $request)
    {
        $order = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $tradeNo = bin2hex(random_bytes(9));
        Order::create([
            'user_id' => Auth::id(),
            'order' => serialize($order),
            'total' => $total,
            'trade_no' => $tradeNo,
        ]);
        $request->session()->flush();
    }
}
