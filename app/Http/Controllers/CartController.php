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
        $orders = $request->session()->get('cart');
        $total = $request->session()->get('total');
        return view('cart.show', ['orders' => $orders, 'total' => $total]);
    }

    public function addItem(Request $request, $id)
    {
        $item = Item::find($id);
        $newOrder = [
            'item' => $item,
            'qty' => 1,
        ];
        if ($request->session()->has('cart')) {
            $order = $request->session()->get('cart');
            if (array_key_exists($id, $order)) {
                $order[$id]['qty']++;
            } else {
                $order[$id] = $newOrder;
            }
        } else {
            $order[$id] = $newOrder;
        }
        $total = $request->session()->has('total') ? $request->session()->get('total') : 0;
        $total += $item->price;
        $request->session()->put('cart', $order);
        $request->session()->put('total', $total);
        return Redirect()->back();
    }

    public function changeQty(Request $request, $id)
    {
        $order = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $qty = $request->qty;
        $oldQty = $order[$id]['qty'];
        $diff = $qty - $oldQty;
        $order[$id]['qty'] = $qty;
        $total += $diff * $order[$id]['item']->price;
        $request->session()->put('cart', $order);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }

    public function deleteItem(Request $request, $id)
    {
        $order = $request->session()->get('cart');
        $total = $request->session()->get('total');
        $total -= $order[$id]['qty'] * $order[$id]['item']->price;
        unset($order[$id]);
        $request->session()->put('cart', $order);
        $request->session()->put('total', $total);
        return Redirect()->action([CartController::class, 'showCart']);
    }
}
